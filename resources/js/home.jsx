import React from "react";
import { createRoot } from "react-dom/client";
import Home from "./Home/Home";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<Home />} />
);
