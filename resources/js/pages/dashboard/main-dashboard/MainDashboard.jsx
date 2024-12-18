// Importing necessary components

import { Breadcrumb } from "react-bootstrap";
import TotalTopStats from "./section/TotalTopStats";
import ProfitLoss from "./section/ProfitLoss";
import SalesAnalytics from "./section/SalesAnalytics";
import TotalCostInOut from "./section/TotalCostInOut";
import PurchaseReport from "./section/PurchaseReport";
import TotalStats from "./section/TotalStats";
import Revenue from "./section/Revenue";
import { useEffect, useState } from "react";

// MainDashboard functional component
const MainDashboard = () => {
    // const [banks, setBanks] = useState({});

    // useEffect(() => {
    //     const url = "http://127.0.0.1:8000/bank/view";
    //     fetch(url)
    //         .then((res) => res.json())
    //         .then((data) => setBanks(data));
    // }, []);

    // console.log(banks);
    return (
        <>
            {/* Breadcrumb component to display page navigation */}
            <Breadcrumb section="Dashboard" title="Main Dashboard" />
            {/* Grid layout for displaying the dashboard cards */}

            <TotalTopStats />
            <section className="row gy-4 mt-1" >
                <ProfitLoss />
                <SalesAnalytics />
                <TotalCostInOut />
                <PurchaseReport />
                <TotalStats />
                <Revenue />
            </section>
        </>
    );
};

// Exporting the MainDashboard component for use in other parts of the application
export default MainDashboard;
