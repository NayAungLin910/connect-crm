import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import Paginator from "../Paginator/Paginator";
import Spinner from "../Spinner/Spinner";

const ViewAccount = () => {
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [view, setView] = useState("10");
    const [searchType, setSearchType] = useState("name");
    const [accounts, setAccounts] = useState([]);
    const [sortTime, setSortTime] = useState("latest");
    const [search, setSearch] = useState("");
    const [curPage, setCurPage] = useState("1");
    const [load, setLoad] = useState(true);
    const [delLoad, setDelLoad] = useState([]);
    const [select, setSelect] = useState([]);
    const [delLoadMul, setDelLoadMul] = useState(false);

    const deleteSelected = () => {
        if (
            window.confirm("Are you sure about deleting the selected accounts?")
        ) {
            setDelLoadMul(true);
            let postData = new FormData();
            postData.append("account_ids", JSON.stringify(select));
            cusaxios.post("/account/delete-multiple", postData).then((res) => {
                // set loading
                setDelLoadMul(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (!success) {
                    // error
                    showToast(data, "error");
                } else {
                    // success
                    if (accounts.data.length === select.length) {
                        // if all accounts shown is deleted
                        let cur_page = parseInt(curPage);
                        if (cur_page > 1) {
                            cur_page--;
                        }
                        setCurPage((curPage) => cur_page.toString());
                    }
                    // filter the deleted accounts
                    select.map((s) =>
                        setAccounts((accounts) => ({
                            ...accounts,
                            data: accounts.data.filter((a) => a.id !== s),
                        }))
                    );
                    setSelect([]);
                    showToast(data, "info");
                }
            });
        }
    };

    // select all rows
    const selectAllRows = () => {
        setSelect([]);
        if (select.length !== accounts.data.length) {
            setSelect((select) => accounts.data.map((a) => a.id));
        }
    };

    // select a row
    const selectRow = (id) => {
        if (select.includes(id)) {
            // if slug is already included filter it
            setSelect((select) => select.filter((s) => s !== id));
        } else {
            // if the slug is not included than include it
            setSelect((select) => [...select, id]);
        }
    };

    // confirm single account delete
    const confirmDelete = (id, name) => {
        if (
            window.confirm(`Are you sure about deleting the account, ${name}?`)
        ) {
            // set loading
            setDelLoad((delLoad) => [...delLoad, id]);
            cusaxios.post(`/account/delete`, { account_id: id }).then((res) => {
                // remove loading
                setDelLoad((delLoad) => delLoad.filter((dl) => dl !== id));
                let res_data = res.data;
                let { success, data } = res_data;
                if (!success) {
                    // if error
                    showToast(data, "error");
                } else {
                    // success
                    if (accounts.data.length === 1) {
                        let cur_page = parseInt(curPage);
                        if (cur_page > 1) {
                            cur_page--;
                        }
                        setCurPage((curPage) => cur_page.toString());
                    }
                    setAccounts((accounts) => ({
                        ...accounts,
                        data: accounts.data.filter((a) => a.id !== id),
                    }));
                    showToast(data, "info");
                }
            });
        }
    };

    // clear filter
    const clearFilter = () => {
        setStartDate("");
        setEndDate("");
        setSortTime("latest");
        setView("10");
        setSearch("");
        setSearchType("latest");
        setCurPage("1");
        setSelect([]);
    };

    const getAccountData = () => {
        cusaxios
            .get(
                `/account/get-data?startdate=${startDate}&enddate=${endDate}&view=${view}&search_value=${search}&time_sort=${sortTime}&search_type=${searchType}&page=${curPage}`
            )
            .then((res) => {
                setLoad(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (!success) {
                    showToast("Something went wrong!", "error");
                } else {
                    setAccounts(data.accounts);
                }
            });
    };

    useEffect(() => {
        getAccountData();
    }, [startDate, endDate, view, search, sortTime, searchType, curPage]);

    return (
        <>
            <div className="row mt-3">
                <h4 className="text-center mb-2">
                    <i className="bi bi-person-video2 mx-2"></i>Account
                    Management
                </h4>
                <div className="col-sm-2 my-2">
                    <div className="form-group">
                        <label htmlFor="input-start-date-id">Start Date</label>
                        <input
                            id="input-start-date-id"
                            type="date"
                            value={startDate}
                            onChange={(e) => {
                                setStartDate(e.target.value);
                            }}
                            className="form-control"
                        />
                    </div>
                </div>
                <div className="col-sm-2 my-2">
                    <div className="form-group">
                        <label htmlFor="input-end-date-id">End Date</label>
                        <input
                            id="input-end-date-id"
                            type="date"
                            value={endDate}
                            onChange={(e) => {
                                setEndDate(e.target.value);
                            }}
                            className="form-control"
                        />
                    </div>
                </div>
                <div className="col-sm-2  my-2">
                    <div className="form-group">
                        <label htmlFor="select-view-id">Record</label>
                        <select
                            id="select-view-id"
                            className="form-select"
                            value={view}
                            onChange={(e) => {
                                setView(e.target.value);
                            }}
                        >
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>
                <div className="col-sm-2  my-2">
                    <div className="form-group">
                        <label htmlFor="select-view-timesort">Sort By</label>
                        <select
                            id="select-view-timesort"
                            className="form-select"
                            value={sortTime}
                            onChange={(e) => {
                                setSortTime(e.target.value);
                            }}
                        >
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                        </select>
                    </div>
                </div>
                <div className="col-sm-2  my-2">
                    <label htmlFor="select-search-type-id">Search By</label>
                    <select
                        id="select-search-type-id"
                        className="form-select"
                        value={searchType}
                        onChange={(e) => {
                            setSearchType(e.target.value);
                        }}
                    >
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                    </select>
                </div>
                <div className="col-sm-3  my-2">
                    <label htmlFor="input-search-id-sort">Search</label>
                    <div className="input-group">
                        <input
                            value={search}
                            onChange={(e) => {
                                setSearch(e.target.value);
                            }}
                            type="search"
                            className="form-control rounded"
                            placeholder="Accounts's name"
                            aria-label="Search"
                            aria-describedby="search-addon"
                            id="input-search-id-sort"
                        />
                    </div>
                </div>
                <div
                    className="col-sm-2"
                    style={{ marginTop: "32px", marginBottom: "20px" }}
                >
                    <button
                        type="button"
                        onClick={clearFilter}
                        className="btn btn-sm btn-primary"
                    >
                        Clear <i className="bi bi-x"></i>
                    </button>
                </div>
            </div>
            {load ? (
                <>
                    <div className="mt-5">
                        <Spinner />
                    </div>
                </>
            ) : accounts.data.length == 0 ? (
                <>
                    <p>No accounts found!</p>
                </>
            ) : (
                <>
                    <div className="col-sm-12 mt-3">
                        <div className="d-flex justify-content-start align-items-center">
                            <div className="px-2">
                                <button
                                    className="btn btn-sm btn-primary"
                                    onClick={selectAllRows}
                                >
                                    {accounts.data.length === select.length ? (
                                        <>Deselect All</>
                                    ) : (
                                        <>Select All</>
                                    )}
                                </button>
                            </div>
                            {select.length > 0 && (
                                <div className="px-2">
                                    <button
                                        className="btn btn-sm btn-danger"
                                        disabled={delLoadMul}
                                        onClick={deleteSelected}
                                    >
                                        {delLoadMul ? (
                                            <span
                                                className="spinner-grow spinner-grow-sm me-1"
                                                role="status"
                                                aria-hidden="true"
                                            ></span>
                                        ) : (
                                            <>Delete Selected</>
                                        )}
                                    </button>
                                </div>
                            )}
                        </div>
                        <div className="table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {accounts.data.map((a) => {
                                        const created_time_formated =
                                            new Intl.DateTimeFormat("en-US", {
                                                year: "numeric",
                                                month: "2-digit",
                                                day: "2-digit",
                                                hour: "2-digit",
                                                minute: "2-digit",
                                                second: "2-digit",
                                            }).format(new Date(a.created_at));
                                        return (
                                            <tr key={a.id}>
                                                <td>
                                                    <div className="form-check">
                                                        <input
                                                            className="form-check-input checkbox-lg"
                                                            type="checkbox"
                                                            checked={select.includes(
                                                                a.id
                                                            )}
                                                            onChange={(e) => {
                                                                selectRow(a.id);
                                                            }}
                                                        />
                                                    </div>
                                                </td>
                                                <td>
                                                    <img
                                                        src={`${baseUrl}storage/images/${a.image}`}
                                                        height={35}
                                                        width={35}
                                                        className="rounded-circle"
                                                        alt={a.name}
                                                    />
                                                </td>
                                                <td>{a.name}</td>
                                                <td>{a.email}</td>
                                                <td>{created_time_formated}</td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        className="btn btn-sm btn-danger"
                                                        disabled={delLoad.includes(
                                                            a.id
                                                        )}
                                                        onClick={(e) => {
                                                            confirmDelete(
                                                                a.id,
                                                                a.name
                                                            );
                                                        }}
                                                    >
                                                        {delLoad.includes(
                                                            a.id
                                                        ) ? (
                                                            <span
                                                                className="spinner-grow spinner-grow-sm"
                                                                role="status"
                                                                aria-hidden="true"
                                                            ></span>
                                                        ) : (
                                                            <i className="bi bi-trash mx-1"></i>
                                                        )}
                                                    </button>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                        <Paginator
                            links={accounts.links}
                            pageChange={setCurPage}
                            current_page={accounts.current_page}
                            next_page_url={accounts.next_page_url}
                            prev_page_url={accounts.prev_page_url}
                        />
                    </div>
                </>
            )}
        </>
    );
};

export default ViewAccount;
