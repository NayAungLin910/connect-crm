import React from "react";
import { HashRouter, Routes, Route } from "react-router-dom";

const MainRouter = ({ runElement }) => {
    return (
        <HashRouter>
            <Routes>
                <Route path="/" element={runElement} />
            </Routes>
        </HashRouter>
    );
};

export default MainRouter;
