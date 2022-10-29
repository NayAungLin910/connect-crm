import React from "react";
import { createRoot } from "react-dom/client";
import ViewContact from "./Contact/ViewContact";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewContact />} />
);
