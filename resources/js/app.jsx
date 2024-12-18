import React from "react";
import ReactDOM from "react-dom/client";
// React Router
import { RouterProvider } from "react-router-dom";
// Importing router configuration
import { router } from "./routes/router";
// Styling imports for different libraries
import 'react-quill/dist/quill.snow.css'; // React Quill editor style
import "jsvectormap/dist/css/jsvectormap.css"; // jsvectormap style
import 'react-toastify/dist/ReactToastify.css'; // React Toastify notifications style
import 'react-modal-video/css/modal-video.min.css'; // Modal video player style
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Bootstrap JS bundle

function App() {
    return (
        <>
            {/* RouterProvider renders the main router configuration */}
            <RouterProvider router={router} />
        </>
    );
}

// Render the App component to the DOM at the element with id "app"
ReactDOM.createRoot(document.getElementById("app")).render(<App />);
