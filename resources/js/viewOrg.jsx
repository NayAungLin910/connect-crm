import React from "react";
import { createRoot } from "react-dom/client";
import MainRouter from "./layout/MainRouter/MainRouter";
import ViewOrg from "./Org/ViewOrg";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewOrg />} />
);
