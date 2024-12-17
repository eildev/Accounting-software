import React from "react";
import ReactDOM from "react-dom/client";
import { RouterProvider } from "react-router-dom";
import { router } from "./routes/router";

function App() {
    return (
        <>
            <RouterProvider router={router} />
        </>
    );
}

ReactDOM.createRoot(document.getElementById("app")).render(<App />);
