import React from "react";
import { createRoot } from "react-dom/client";
import MainRouter from "./layout/MainRouter/MainRouter";
import ViewLead from "./Lead/ViewLead";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewLead />} />
);
