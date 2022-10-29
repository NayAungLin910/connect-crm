import React from "react";
import { createRoot } from "react-dom/client";
import MainRouter from "./layout/MainRouter/MainRouter";
import ViewSource from "./Source/ViewSource";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewSource />} />
);