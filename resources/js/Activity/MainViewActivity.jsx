import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import Spinner from "../Spinner/Spinner";
import Paginator from "../Paginator/Paginator";

const MainViewActivity = () => {
    const [loading, setLoading] = useState(true);
    const [by, setBy] = useState(window.by);
    const [view, setView] = useState("10");
    const [activities, setActivities] = useState();
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [search, setSearch] = useState("");
    const [curPage, setCurPage] = useState();
    const [timeSort, setTimeSort] = useState("oldest");
    const [type, setType] = useState("any");
    const [done, setDone] = useState("no");
    const [loadDone, setLoadDone] = useState([]);

    // confirmation of deleting the activity
    const confirmDelete = (slug, name) => {
        if (
            window.confirm(`Are you sure about deleting the activity, ${name}?`)
        ) {
            setLoading(true);
            cusaxios
                .post(`/activity/delete`, { activity_slug: slug })
                .then(({ data }) => {
                    setLoading(false);
                    if (data.success) {
                        if (activities.data.length == 1) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                            getActivities();
                        }
                        setActivities((activities) => ({
                            ...activities,
                            data: activities.data.filter(
                                (a) => a.slug !== slug
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
        setView("10");
        setStartDate("");
        setEndDate("");
        setSearch("");
        setTimeSort("oldest");
        setType("any");
        setDone("no");
        setBy("anyone");
    };

    // done or not done toogle function
    const doneOrNotDone = (slug) => {
        // show loader
        setLoadDone((loadDone) => [...loadDone, slug]);
        const actData = new FormData();
        actData.append("activity_slug", slug);
        cusaxios.post("/activity/done", actData).then(({ data }) => {
            // hide loader
            setLoadDone((loadDone) => loadDone.filter((ld) => ld !== slug));
            // toogle the activity's done
            setActivities((activities) => ({
                ...activities,
                data: activities.data.map((a) => {
                    if (a.slug == slug) {
                        if (a.done == "yes") {
                            return {
                                ...a,
                                done: "no",
                            };
                        } else {
                            return {
                                ...a,
                                done: "yes",
                            };
                        }
                    }
                    return a;
                }),
            }));
            if (!data.success) {
                showToast("Something went wrong!", "error");
            }
        });
    };

    // get paginated activity data
    const getActivities = () => {
        cusaxios
            .get(
                `/activity/view?startdate_activity=${startDate}&enddate_activity=${endDate}&search=${search}&activity_time_sort=${timeSort}&type=${type}&user_type=${window.type}&user_id=${window.auth.id}&view=${view}&by=${by}&done=${done}&page=${curPage}`
            )
            .then((res) => {
                let res_data = res.data;
                let { success, status, data } = res_data;
                setActivities(data.activities);
                setLoading(false);
            });
    };

    useEffect(() => {
        getActivities();
    }, [curPage, startDate, endDate, search, timeSort, type, done, view, by]);

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
                        <i className="bi bi-list-task mx-2"></i>Activities
                    </h3>
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
                            <label htmlFor="timeSort-filter">
                                Sort By Start Date
                            </label>
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
                                <option value="oldest">Closest</option>
                                <option value="latest">Furthest</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-sm-2 my-2">
                        <div className="form-group">
                            <label htmlFor="typesort-filter">Type</label>
                            <select
                                className="form-select"
                                value={type}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setType(e.target.value);
                                }}
                                name="typesort-filter"
                                id="typesort-filter"
                            >
                                <option value="any">Any</option>
                                <option value="meeting">Meeting</option>
                                <option value="call">Call</option>
                                <option value="vc">VC</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-sm-2 my-2">
                        <div className="form-group">
                            <label htmlFor="donesort-filter">Done</label>
                            <select
                                className="form-select"
                                value={done}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setDone(e.target.value);
                                }}
                                name="donesort-filter"
                                id="donesort-filter"
                            >
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                                <option value="any">Any</option>
                            </select>
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
                            <label htmlFor="by-select">By</label>
                            <select
                                className="form-select"
                                name="by"
                                value={by}
                                onChange={(e) => {
                                    setCurPage(1);
                                    setBy(e.target.value);
                                }}
                                id="by-select"
                            >
                                <option value="anyone">Anyone</option>
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
                                placeholder="Activity's title"
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
                    <div className="col-sm-12 my-3">
                        <div className="row">
                            {activities.data.length == 0 ? (
                                <>
                                    <p>No activity found!</p>
                                </>
                            ) : (
                                activities.data.map((a) => {
                                    const start_time = new Intl.DateTimeFormat(
                                        "en-US",
                                        {
                                            year: "numeric",
                                            month: "2-digit",
                                            day: "2-digit",
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit",
                                        }
                                    ).format(new Date(a.start_date));
                                    const end_time = new Intl.DateTimeFormat(
                                        "en-US",
                                        {
                                            year: "numeric",
                                            month: "2-digit",
                                            day: "2-digit",
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit",
                                        }
                                    ).format(new Date(a.end_date));
                                    return (
                                        <div className="col-sm-4" key={a.id}>
                                            <div className="card m-1">
                                                <div className="card-header bg-dark text-white">
                                                    <h5 className="card-title text-center">
                                                        {a.name}
                                                    </h5>
                                                </div>
                                                <div className="card-body">
                                                    <p className="text-justify">
                                                        {a.description}
                                                    </p>
                                                    <div
                                                        className="d-flex flex-row justify-content-between"
                                                        style={{
                                                            fontSize: "12px",
                                                        }}
                                                    >
                                                        <div>
                                                            <p className="mb-1">
                                                                Start Date
                                                            </p>
                                                            <i>{start_time}</i>
                                                        </div>
                                                        <div>
                                                            <p className="mb-1">
                                                                End Date
                                                            </p>
                                                            <i>{end_time}</i>
                                                        </div>
                                                    </div>
                                                    <div className="mt-4 mb-2">
                                                        <a
                                                            href={`${baseUrl}storage/files/${a.file}`}
                                                            target="_blank"
                                                            className="btn btn-sm btn-primary"
                                                        >
                                                            <i className="bi bi-download mx-2"></i>
                                                            {a.file_name}
                                                        </a>
                                                    </div>
                                                    <div className="my-2">
                                                        {loadDone.some((ld) => {
                                                            if (ld === a.slug) {
                                                                return true;
                                                            }

                                                            return false;
                                                        }) ? (
                                                            <div
                                                                className="spinner-grow spinner-grow-sm text-dark"
                                                                role="status"
                                                            ></div>
                                                        ) : (
                                                            <div className="form-check">
                                                                <input
                                                                    className="form-check-input"
                                                                    type="checkbox"
                                                                    checked={
                                                                        a.done ==
                                                                        "yes"
                                                                    }
                                                                    id={`flexCheckChecked-${a.slug}`}
                                                                    onChange={() => {
                                                                        doneOrNotDone(
                                                                            a.slug
                                                                        );
                                                                    }}
                                                                />
                                                                <label
                                                                    className="form-check-label"
                                                                    htmlFor={`flexCheckChecked-${a.slug}`}
                                                                >
                                                                    Done
                                                                </label>
                                                            </div>
                                                        )}
                                                    </div>
                                                    <div className="my-2">
                                                        {a.admin && (
                                                            <>
                                                                <p className="text-justify">
                                                                    <i className="bi bi-person-fill mx-1"></i>
                                                                    {
                                                                        a.admin
                                                                            .name
                                                                    }
                                                                </p>
                                                            </>
                                                        )}
                                                        {a.moderator && (
                                                            <>
                                                                <p className="text-justify">
                                                                    <i className="bi bi-person-fill mx-1"></i>
                                                                    {
                                                                        a
                                                                            .moderator
                                                                            .name
                                                                    }
                                                                </p>
                                                            </>
                                                        )}
                                                    </div>
                                                    <div className="d-flex flex-row justify-content-between mt-3">
                                                        <a
                                                            href={`${baseUrl}activity/edit/${a.slug}`}
                                                            className="btn btn-sm btn-primary"
                                                        >
                                                            <i className="bi bi-pencil-square mx-1"></i>
                                                            Edit
                                                        </a>
                                                        <button
                                                            onClick={() => {
                                                                confirmDelete(
                                                                    a.slug,
                                                                    a.name
                                                                );
                                                            }}
                                                            className="btn btn-sm btn-danger"
                                                        >
                                                            <i className="bi bi-trash mx-1"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })
                            )}
                        </div>
                    </div>
                    <Paginator
                        links={activities.links}
                        pageChange={pageChange}
                        current_page={activities.current_page}
                        next_page_url={activities.next_page_url}
                        prev_page_url={activities.prev_page_url}
                    />
                </div>
            )}
        </>
    );
};

export default MainViewActivity;
