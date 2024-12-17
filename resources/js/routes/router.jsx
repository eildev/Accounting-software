import { createBrowserRouter } from "react-router-dom";
import MainLayouts from "../layouts/MainLayouts";
import MainDashboard from "../pages/MainDashboard";
import SaleDashboard from "../pages/SaleDashboard";
import AssetDashboard from "../pages/AssetDashboard";
import ExpenseDashboard from "../pages/ExpenseDashboard";
import PayrollDashboard from "../pages/PayrollDashboard";

export const router = createBrowserRouter([
    {
        path: "/",
        element: <MainLayouts />,
        children: [
            {
                path: "/",
                element: <MainDashboard />,
            },
            {
                path: "/sale-dashboard",
                element: <SaleDashboard />,
            },
            {
                path: "/asset-dashboard",
                element: <AssetDashboard />,
            },
            {
                path: "/expense-dashboard",
                element: <ExpenseDashboard />,
            },
            {
                path: "/payroll-dashboard",
                element: <PayrollDashboard />,
            },
        ],
    },
]);
