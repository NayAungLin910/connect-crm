import React from "react";

const Paginator = ({
    links,
    pageChange,
    current_page,
    next_page_url,
    prev_page_url,
}) => {
    const handleClick = (pageNumber) => {
        pageChange(pageNumber);
    };

    const MiddleLink = ({ index, length, link }) => {
        if (index !== 0 && index !== length - 1) {
            return (
                <li
                    className={`page-item ${
                        current_page == link.label ? "active" : ""
                    }`}
                >
                    <a
                        className="page-link"
                        onClick={() => {
                            handleClick(link.label);
                        }}
                    >
                        {link.label}
                    </a>
                </li>
            );
        }
    };

    return (
        <>
            <nav aria-label="Page navigation example" className="my-3">
                <ul className="pagination justify-content-center">
                    <li
                        className={`page-item ${
                            !prev_page_url ? "disabled" : ""
                        }`}
                    >
                        <a
                            className="page-link"
                            onClick={() => {
                                handleClick(current_page - 1);
                            }}
                            style={{
                                backgroundColor: !prev_page_url
                                    ? "#DCDCDC"
                                    : "",
                            }}
                        >
                            <i
                                className={`bi bi-chevron-double-left text-${
                                    !prev_page_url ? "dark" : "primary"
                                }`}
                            ></i>
                        </a>
                    </li>
                    {links.map((l, i) => (
                        <MiddleLink
                            key={i}
                            index={i}
                            length={links.length}
                            link={l}
                        />
                    ))}
                    <li
                        className={`page-item ${
                            !next_page_url ? "disabled" : ""
                        }`}
                    >
                        <a
                            className="page-link"
                            onClick={() => {
                                handleClick(current_page + 1);
                            }}
                            style={{
                                backgroundColor: !next_page_url
                                    ? "#DCDCDC"
                                    : "",
                            }}
                        >
                            <i
                                className={`bi bi-chevron-double-right text-${
                                    !next_page_url ? "dark" : "primary"
                                }`}
                            ></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </>
    );
};

export default Paginator;
