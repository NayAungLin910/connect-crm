import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import Spinner from "../Spinner/Spinner";
import Paginator from "../Paginator/Paginator";

const ViewLead = () => {
    const [loading, setLoading] = useState(true);
    const [by, setBy] = useState(window.by);
    const [leads, setLeads] = useState({});
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [startCloseDate, setStartCloseDate] = useState("");
    const [endCloseDatae, setEndCloseDate] = useState("");
    const [search, setSearch] = useState("");
    const [view, setView] = useState(10);
    const [progressOption, setProgressOption] = useState("any");
    const [curPage, setCurPage] = useState();
    const [timeSort, setTimeSort] = useState("");
    const [select, setSelect] = useState([]);
    const [excelYear, setExcelYear] = useState(new Date().getFullYear());
    let currentYear = new Date().getFullYear();
    let yearRange = [];
    for (currentYear; currentYear >= 2000; currentYear--) {
        yearRange.push(currentYear);
    }

    // confirmation of deleting lead
    const confirmDelete = (slug, name) => {
        if (window.confirm(`Are you sure about deleting the lead, ${name}?`)) {
            cusaxios
                .post(`/lead/delete`, { lead_slug: slug })
                .then(({ data }) => {
                    if (data.success) {
                        if (leads.data.length == 1) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                            getLeads();
                        }
                        setLeads((leads) => ({
                            ...leads,
                            data: leads.data.filter((l) => l.slug !== slug),
                        }));
                        showToast(`${name} has been deleted!`, "info");
                    } else {
                        showToast("Something went wrong!", "error");
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
        setProgressOption("any");
        setStartCloseDate("");
        setEndCloseDate("");
        setBy("anyone");
    };

    // select all rows
    const selectAllRows = () => {
        setSelect([]);
        if (select.length !== leads.data.length) {
            leads.data.map((l) => {
                setSelect((oldSelect) => [...oldSelect, l.slug]);
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
        if (window.confirm("Are you sure about deleting the selected leads?")) {
            const fData = new FormData();
            fData.append("lead_slugs", JSON.stringify(select));

            cusaxios.post(`/lead/delete-multiple`, fData).then(({ data }) => {
                if (data.success) {
                    if (select.length === leads.data.length) {
                        if (curPage > 1) {
                            setCurPage((curPage) => curPage - 1);
                        } else {
                            setCurPage(1);
                        }
                        getLeads();
                    }
                    // minus the deleted organizations
                    select.map((s) => {
                        setLeads((leads) => ({
                            ...leads,
                            data: leads.data.filter((l) => l.slug !== s),
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

    // get paginated lead data
    const getLeads = () => {
        cusaxios
            .get(
                `/lead/view?startdate=${startDate}&enddate=${endDate}&view=${view}&search=${search}&time_sort=${timeSort}&progress_option=${progressOption}&by=${by}&user_id=${window.auth.id}&fil_source_slug=${window.source_slug}&fil_business_slug=${window.business_slug}&fil_contact_slug=${window.contact_slug}&user_type=${window.type}&start_close_date=${startCloseDate}&end_close_date=${endCloseDatae}&page=${curPage}`
            )
            .then((res) => {
                let res_data = res.data;
                let { success, status, data } = res_data;
                setLeads(data.leads);
                setLoading(false);
            });
    };

    useEffect(() => {
        getLeads();
    }, [
        curPage,
        startDate,
        endDate,
        view,
        search,
        timeSort,
        progressOption,
        startCloseDate,
        endCloseDatae,
        by,
    ]);

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
                        <i className="bi bi-people-fill mx-2"></i>Leads
                    </h3>
                    <div className="col-sm-2 my-2">
                        <div className="form-group">
                            <label htmlFor="view-filter">Choose Progress</label>
                            <select
                                className="form-select"
                                value={progressOption}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setProgressOption(e.target.value);
                                }}
                                name="progress_option"
                                id="view-filter"
                            >
                                <option value="any">Any</option>
                                <option value="new">New</option>
                                <option value="follow up">Follow Up</option>
                                <option value="prospect">Prospect</option>
                                <option value="negotiation">Negotiation</option>
                                <option value="won">Won</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-sm-2 my-2">
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
                    <div className="col-sm-2 my-2">
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
                    <div className="col-sm-2 my-2">
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
                    <div className="col-sm-2 my-2">
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
                    <div className="row">
                        <div className="col-sm-2 my-2">
                            <div className="form-group">
                                <label htmlFor="input-startclosetdate">
                                    Start Expected Closing Date
                                </label>
                                <input
                                    type="date"
                                    className="form-control"
                                    value={startCloseDate}
                                    onChange={(e) => {
                                        setCurPage(1);
                                        setStartCloseDate(e.target.value);
                                    }}
                                    id="input-startclosetdate"
                                />
                            </div>
                        </div>
                        <div className="col-sm-2 my-2">
                            <div className="form-group">
                                <label htmlFor="input-endclosetdate">
                                    End Expected Closing Date
                                </label>
                                <input
                                    type="date"
                                    className="form-control"
                                    value={endCloseDatae}
                                    onChange={(e) => {
                                        setCurPage(1);
                                        setEndCloseDate(e.target.value);
                                    }}
                                    id="input-endclosetdate"
                                />
                            </div>
                        </div>
                        <div className="col-sm-2 my-2">
                            <div className="form-group">
                                <label htmlFor="select-by-id">By</label>
                                <select
                                    className="form-select"
                                    value={by}
                                    onChange={(e) => {
                                        setCurPage(1);
                                        setBy(e.target.value);
                                    }}
                                    id="select-by-id"
                                >
                                    <option value="anone">Anyone</option>
                                    <option value="me">Me</option>
                                </select>
                            </div>
                        </div>
                        <div className="col-sm-3 my-2">
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
                                    placeholder="Lead's name"
                                    aria-label="Search"
                                    aria-describedby="search-addon"
                                    id="input-search"
                                />
                            </div>
                        </div>
                        <div className="col-2" style={{ marginTop: "32px" }}>
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
                    </div>
                    {leads.data.length > 0 && (
                        <>
                            <div className="d-flex justify-content-start align-items-center">
                                <div className="px-2">
                                    <label htmlFor="select-year-lead-yearly-bar">
                                        Excel Export Year:{" "}
                                    </label>
                                    <select
                                        value={excelYear}
                                        id="select-year-lead-yearly-bar"
                                        className="form-select"
                                        aria-label="Default select example"
                                        onChange={(e) => {
                                            setExcelYear(e.target.value);
                                        }}
                                    >
                                        {yearRange.map((year) => (
                                            <option key={year} value={year}>
                                                {year}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div className="px-2 mt-3">
                                    <a
                                        href={`${baseUrl}lead/download/${excelYear}`}
                                        className="btn btn-sm btn-success"
                                    >
                                        <i className="bi bi-file-earmark-excel-fill mx-1"></i>
                                        Download Excel
                                    </a>
                                </div>
                            </div>
                            <div className="d-flex my-3 justify-content-start align-items-center">
                                <div className="px-2">
                                    <button
                                        className="btn btn-sm btn-primary"
                                        onClick={selectAllRows}
                                    >
                                        Select All
                                    </button>
                                </div>
                                {select.length > 0 && (
                                    <div className="px-2">
                                        <button
                                            className="btn btn-sm btn-danger"
                                            onClick={deleteSelected}
                                        >
                                            Delete Selected
                                        </button>
                                    </div>
                                )}
                            </div>
                        </>
                    )}

                    <div className="col-sm-12 mt-3">
                        <div className="table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th style={{ whiteSpace: "nowrap" }}>
                                            Expected Closing Date
                                        </th>
                                        <th style={{ whiteSpace: "nowrap" }}>
                                            Created Date
                                        </th>
                                        <th>Description</th>
                                        <th>Value</th>
                                        <th>Source</th>
                                        <th>Progress</th>
                                        <th>Moderator</th>
                                        <th>Admin</th>
                                        <th>Contact</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Source</th>
                                        <th>Business</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {leads.data.length == 0 ? (
                                        <tr>
                                            <td></td>
                                            <td colSpan={16}>No lead found!</td>
                                        </tr>
                                    ) : (
                                        leads.data.map((l, index) => {
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
                                                    new Date(l.created_at)
                                                );
                                            const formatted_close_time =
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
                                                    new Date(l.close_date)
                                                );

                                            let badgeColor = "";

                                            switch (l.progress) {
                                                case "new":
                                                    badgeColor = "#B4D3D1";
                                                    break;
                                                case "follow up":
                                                    badgeColor = "#39CAE7";
                                                    break;
                                                case "prospect":
                                                    badgeColor = "#7DE771";
                                                    break;
                                                case "negotiation":
                                                    badgeColor = "#5EE935";
                                                    break;
                                                case "won":
                                                    badgeColor = "#CE41EA";
                                                    break;
                                                case "lost":
                                                    badgeColor = "#F1793D";
                                                    break;
                                                default:
                                                    badgeColor = "#8CD1A3";
                                            }

                                            return (
                                                <tr key={l.id}>
                                                    <td className="text-center">
                                                        <div>
                                                            <input
                                                                checked={select.includes(
                                                                    l.slug
                                                                )}
                                                                type="checkbox"
                                                                className="form-check-input checkbox-lg"
                                                                onChange={() => {
                                                                    selectRow(
                                                                        l.slug
                                                                    );
                                                                }}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>{l.name}</td>
                                                    <td>
                                                        {formatted_close_time}
                                                    </td>
                                                    <td>{formated_time}</td>
                                                    <td>{l.description}</td>
                                                    <td>{l.value}</td>
                                                    <td>{l.source.name}</td>
                                                    <td>
                                                        <span
                                                            style={{
                                                                backgroundColor:
                                                                    badgeColor,
                                                                borderRadius:
                                                                    "9px",
                                                                whiteSpace:
                                                                    "nowrap",
                                                            }}
                                                            className="text-white p-1"
                                                        >
                                                            {l.progress}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {l.moderator ? (
                                                            <>
                                                                {
                                                                    l.moderator
                                                                        .name
                                                                }
                                                            </>
                                                        ) : (
                                                            <p>
                                                                <i>null</i>
                                                            </p>
                                                        )}
                                                    </td>
                                                    <td>
                                                        {l.admin ? (
                                                            <>{l.admin.name}</>
                                                        ) : (
                                                            <p>
                                                                <i>null</i>
                                                            </p>
                                                        )}
                                                    </td>
                                                    <td>{l.contact.name}</td>
                                                    <td>{l.product.name}</td>
                                                    <td>{l.quantity}</td>
                                                    <td>{l.amount}</td>
                                                    <td>{l.source.name}</td>
                                                    <td>{l.business.name}</td>
                                                    <td className="text-end">
                                                        <a
                                                            href={`${baseUrl}lead/edit/${l.slug}`}
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
                                                                    l.slug,
                                                                    l.name
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
                            links={leads.links}
                            pageChange={pageChange}
                            current_page={leads.current_page}
                            next_page_url={leads.next_page_url}
                            prev_page_url={leads.prev_page_url}
                        />
                    </div>
                </div>
            )}
        </>
    );
};

export default ViewLead;
