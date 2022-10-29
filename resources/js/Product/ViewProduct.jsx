import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import Spinner from "../Spinner/Spinner";
import Paginator from "../Paginator/Paginator";

const ViewProduct = () => {
    const [loading, setLoading] = useState(true);
    const [products, setProducts] = useState({});
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [search, setSearch] = useState("");
    const [view, setView] = useState(10);
    const [curPage, setCurPage] = useState("");
    const [timeSort, setTimeSort] = useState("");
    const [select, setSelect] = useState([]);

    // confirmation of deleting product
    const confirmDelete = (slug, name) => {
        if (
            window.confirm(`Are you sure about deleting the product, ${name}?`)
        ) {
            cusaxios
                .post(`/product/delete`, { product_slug: slug })
                .then(({ data }) => {
                    if (data.success) {
                        if (products.data.length === 1) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                            getProducts();
                        }
                        setProducts((products) => ({
                            ...products,
                            data: products.data.filter((p) => p.slug !== slug),
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
        if (select.length !== products.data.length) {
            products.data.map((p) => {
                setSelect((oldSelect) => [...oldSelect, p.slug]);
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
            window.confirm("Are you sure about deleting the selected products?")
        ) {
            const fData = new FormData();
            fData.append("product_slugs", JSON.stringify(select));

            cusaxios
                .post(`/product/delete-multiple`, fData)
                .then(({ data }) => {
                    if (data.success) {
                        if (select.length === products.data.length) {
                            if (curPage > 1) {
                                setCurPage((curPage) => curPage - 1);
                            } else {
                                setCurPage(1);
                            }
                            getProducts();
                        }
                        // minus the deleted products
                        select.map((s) => {
                            setProducts((products) => ({
                                ...products,
                                data: products.data.filter((p) => p.slug !== s),
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

    // get paginated product data
    const getProducts = () => {
        cusaxios
            .get(
                `/product/view?startdate=${startDate}&enddate=${endDate}&view=${view}&search=${search}&time_sort=${timeSort}&page=${curPage}`
            )
            .then((res) => {
                let res_data = res.data;
                let { success, status, data } = res_data;
                setProducts(data.products);
                setLoading(false);
            });
    };

    useEffect(() => {
        getProducts();
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
                    <h3 className="text-center mb-3"><i className="bi bi-box mx-2"></i>Products</h3>
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
                                placeholder="Product's name"
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
                    {products.data.length > 0 && (
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
                                        <th></th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {products.data.length == 0 ? (
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colSpan={7}>
                                                No product found!
                                            </td>
                                        </tr>
                                    ) : (
                                        products.data.map((p, index) => {
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
                                                    new Date(p.created_at)
                                                );

                                            return (
                                                <tr key={p.id}>
                                                    <td className="text-center">
                                                        <div>
                                                            <input
                                                                checked={select.includes(
                                                                    p.slug
                                                                )}
                                                                type="checkbox"
                                                                className="form-check-input checkbox-lg"
                                                                onChange={() => {
                                                                    selectRow(
                                                                        p.slug
                                                                    );
                                                                }}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img
                                                            className="rounded-circle"
                                                            width={55}
                                                            height={55}
                                                            src={
                                                                baseUrl +
                                                                "storage/images/" +
                                                                p.image
                                                            }
                                                            alt={p.name}
                                                        />
                                                    </td>
                                                    <td>{p.name}</td>
                                                    <td>{p.sku}</td>
                                                    <td>{formated_time}</td>
                                                    <td>{p.description}</td>
                                                    <td>{p.price}</td>
                                                    <td className="text-end">
                                                        <a
                                                            href={`${baseUrl}product/edit/${p.slug}`}
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
                                                                    p.slug,
                                                                    p.name
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
                            links={products.links}
                            pageChange={pageChange}
                            current_page={products.current_page}
                            next_page_url={products.next_page_url}
                            prev_page_url={products.prev_page_url}
                        />
                    </div>
                </div>
            )}
        </>
    );
};

export default ViewProduct;
