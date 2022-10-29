import React from "react";
import { createRoot } from "react-dom/client";
import ViewProduct from "./Product/ViewProduct";
import MainRouter from "./layout/MainRouter/MainRouter";

createRoot(document.getElementById("root")).render(
    <MainRouter runElement={<ViewProduct />} />
);