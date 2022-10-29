import React from "react";
import { createRoot } from "react-dom/client";
import ViewActivity from "./Activity/ViewActivity";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewActivity />} />
);
