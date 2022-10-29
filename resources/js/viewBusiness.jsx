import React from "react";
import { createRoot } from "react-dom/client";
import ViewBusiness from "./Business/ViewBusiness";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewBusiness />} />
);
