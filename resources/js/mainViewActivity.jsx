import React from "react";
import { createRoot } from "react-dom/client";
import MainViewActivity from "./Activity/MainViewActivity";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<MainViewActivity />} />
);
