import React from "react";

const Spinner = () => {
    return (
        <>
            <div className="text-center">
                <div
                    className="spinner-grow text-dark"
                    style={{ width: "5rem", height: "5rem" }}
                    role="status"
                >
                </div>
            </div>
        </>
    );
};

export default Spinner;
