import React from "react";
import { createRoot } from "react-dom/client";
import MainRouter from "./layout/MainRouter/MainRouter";
import ViewAccount from "./ViewAccount/ViewAccount";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewAccount />} />
);
