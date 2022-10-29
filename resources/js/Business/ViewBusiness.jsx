import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import Spinner from "../Spinner/Spinner";
import Paginator from "../Paginator/Paginator";

const ViewBusiness = () => {
    const [loading, setLoading] = useState(true);
    const [businesses, setBusinesses] = useState({});
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [search, setSearch] = useState("");
    const [view, setView] = useState(10);
    const [curPage, setCurPage] = useState("");
    const [timeSort, setTimeSort] = useState("");
    const [select, setSelect] = useState([]);

    // confirmation of deleting business
    const confirmDelete = (slug, name) => {
        if (
            window.confirm(`Are you sure about deleting the business, ${name}?`)
        ) {
            cusaxios
                .post(`/business/delete`, { business_slug: slug })
                .then(({ data }) => {
                    if (data.success) {
                        if (businesses.data.length === 1) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                            getBusinesses();
                        }
                        setBusinesses((businesses) => ({
                            ...businesses,
                            data: businesses.data.filter(
                                (b) => b.slug !== slug
                            ),
                        }));
                        showToast(`${name} has been deleted!`, "info");
                    } else {
                        showToast("Something went wrong", "error");
                    }
                });
        }
    };

    // handle page change
    const pageChange = (pageNumber) => {
        setCurPage(pageNumber);
    };

    // clear filters
    const clearFilters = () => {
        setStartDate("");
        setEndDate("");
        setSearch("");
        setView(10);
        setTimeSort("");
    };

    // select all rows
    const selectAllRows = () => {
        setSelect([]);
        if (select.length !== businesses.data.length) {
            businesses.data.map((b) => {
                setSelect((oldSelect) => [...oldSelect, b.slug]);
            });
        }
    };

    // select row handler
    const selectRow = (slug) => {
        if (select.includes(slug)) {
            setSelect(
                select.filter((s) => {
                    return s !== slug;
                })
            );
        } else {
            setSelect((oldSelect) => [...oldSelect, slug]);
        }
    };

    // delete selected
    const deleteSelected = () => {
        if (
            window.confirm(
                "Are you sure about deleting the selected businesses?"
            )
        ) {
            const fData = new FormData();
            fData.append("business_slugs", JSON.stringify(select));

            cusaxios
                .post(`/business/delete-multiple`, fData)
                .then(({ data }) => {
                    if (data.success) {
                        if (select.length === businesses.data.length) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                        }
                        // minus the deleted businesses
                        select.map((s) => {
                            setBusinesses((businesses) => ({
                                ...businesses,
                                data: businesses.data.filter(
                                    (b) => b.slug !== s
                                ),
                            }));
                        });
                        // clear select state
                        setSelect([]);

                        showToast(data.data, "info");
                    } else {
                        showToast(data.data, "error");
                    }
                });
        }
    };

    // get paginated business data
    const getBusinesses = () => {
        cusaxios
            .get(
                `/business/view?startdate=${startDate}&enddate=${endDate}&view=${view}&search=${search}&time_sort=${timeSort}&page=${curPage}`
            )
            .then((res) => {
                let res_data = res.data;
                let { success, status, data } = res_data;
                setBusinesses(data.businesses);
                setLoading(false);
            });
    };

    useEffect(() => {
        getBusinesses();
    }, [curPage, startDate, endDate, view, search, timeSort]);

    return (
        <>
            {loading ? (
                <>
                    <div className="mt-5">
                        <Spinner />
                    </div>
                </>
            ) : (
                <div className="row mt-4">
                    <h3 className="text-center mb-3">
                        <i className="bi bi-briefcase mx-2"></i>Businesses
                    </h3>
                    <div className="col-sm-2">
                        <div className="form-group">
                            <label htmlFor="input-startdate">Start Date</label>
                            <input
                                type="date"
                                className="form-control"
                                value={startDate}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setStartDate(e.target.value);
                                }}
                                id="input-startdate"
                            />
                        </div>
                    </div>
                    <div className="col-sm-2">
                        <div className="form-group">
                            <label htmlFor="input-enddate">End Date</label>
                            <input
                                type="date"
                                className="form-control"
                                value={endDate}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setEndDate(e.target.value);
                                }}
                                id="input-enddate"
                            />
                        </div>
                    </div>
                    <div className="col-sm-2">
                        <div className="form-group">
                            <label htmlFor="view-filter">Records</label>
                            <select
                                className="form-select"
                                value={view}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setView(e.target.value);
                                }}
                                name="view"
                                id="view-filter"
                            >
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-sm-2">
                        <div className="form-group">
                            <label htmlFor="timeSort-filter">Sort By</label>
                            <select
                                className="form-select"
                                value={timeSort}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setTimeSort(e.target.value);
                                }}
                                name="time_sort"
                                id="timeSort-filter"
                            >
                                <option value="latest">Latest</option>
                                <option value="oldest">Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-sm-3">
                        <label htmlFor="input-search">Search</label>
                        <div className="input-group">
                            <input
                                value={search}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setSearch(e.target.value);
                                }}
                                type="search"
                                className="form-control rounded"
                                placeholder="Business's name"
                                aria-label="Search"
                                aria-describedby="search-addon"
                                id="input-search"
                            />
                        </div>
                    </div>
                    <div className="col-2 mt-4">
                        <button
                            className="btn btn-sm btn-primary"
                            onClick={() => {
                                clearFilters();
                            }}
                        >
                            <i className="bi bi-arrow-clockwise mx-1"></i>
                            Clear
                        </button>
                    </div>
                    {businesses.data.length > 0 && (
                        <div className="col-sm-12 mt-3">
                            <button
                                className="btn btn-sm btn-primary"
                                onClick={() => {
                                    selectAllRows();
                                }}
                            >
                                Select All
                            </button>
                            {select.length > 0 && (
                                <button
                                    className="btn btn-sm btn-danger mx-3"
                                    onClick={() => {
                                        deleteSelected();
                                    }}
                                >
                                    Delete Selected
                                </button>
                            )}
                        </div>
                    )}

                    <div className="col-sm-12 mt-3">
                        <div className="table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Lead Count</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {businesses.data.length == 0 ? (
                                        <tr>
                                            <td></td>
                                            <td colSpan={5}>
                                                No business found!
                                            </td>
                                        </tr>
                                    ) : (
                                        businesses.data.map((b, index) => {
                                            const formated_time =
                                                new Intl.DateTimeFormat(
                                                    "en-US",
                                                    {
                                                        year: "numeric",
                                                        month: "2-digit",
                                                        day: "2-digit",
                                                        hour: "2-digit",
                                                        minute: "2-digit",
                                                        second: "2-digit",
                                                    }
                                                ).format(
                                                    new Date(b.created_at)
                                                );

                                            return (
                                                <tr key={b.id}>
                                                    <td className="text-center">
                                                        <div>
                                                            <input
                                                                checked={select.includes(
                                                                    b.slug
                                                                )}
                                                                type="checkbox"
                                                                className="form-check-input checkbox-lg"
                                                                onChange={() => {
                                                                    selectRow(
                                                                        b.slug
                                                                    );
                                                                }}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>{b.name}</td>
                                                    <td>{formated_time}</td>
                                                    <td>
                                                        <a
                                                            href={`${baseUrl}lead/view?business_slug=${b.slug}`}
                                                            className={`btn btn-sm btn-primary ${
                                                                b.lead_count ===
                                                                0
                                                                    ? "disabled"
                                                                    : ""
                                                            }`}
                                                        >
                                                            {b.lead_count}
                                                        </a>
                                                    </td>
                                                    <td className="text-end">
                                                        <a
                                                            href={`${baseUrl}business/edit/${b.slug}`}
                                                            className="btn btn-sm btn-primary"
                                                        >
                                                            <i className="bi bi-pencil-square mx-1"></i>
                                                            Edit
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button
                                                            onClick={() => {
                                                                confirmDelete(
                                                                    b.slug,
                                                                    b.name
                                                                );
                                                            }}
                                                            className="btn btn-sm btn-danger"
                                                        >
                                                            <i className="bi bi-trash mx-1"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            );
                                        })
                                    )}
                                </tbody>
                            </table>
                        </div>
                        <Paginator
                            links={businesses.links}
                            pageChange={setCurPage}
                            current_page={businesses.current_page}
                            next_page_url={businesses.next_page_url}
                            prev_page_url={businesses.prev_page_url}
                        />
                    </div>
                </div>
            )}
        </>
    );
};

export default ViewBusiness;
