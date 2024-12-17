import Breadcrumb from "../components/breadcrumb/Breadcrumb";
import DashboardCard from "../components/card/DashboardCard";
const data = [
    {
        id: 1,
        name: "Assets",
        value: 9102,
        icon: "solar:wallet-money-bold",
        stats: 5000,
        color: "cyan",
    },
    {
        id: 2,
        name: "Liabilities",
        value: 27891,
        icon: "tabler:report-money",
        stats: -2000,
        color: "purple",
    },
    {
        id: 3,
        name: "Income",
        value: 46828,
        icon: "solar:money-bag-bold",
        stats: 7000,
        color: "info",
    },
    {
        id: 4,
        name: "Expanse",
        value: 34258,
        icon: "solar:card-recive-bold",
        stats: -400,
        color: "success-main",
    },
];
const MainDashboard = () => {
    return (
        <>
            <Breadcrumb title="Main Dashboard" />
            <div className="row row-cols-xxxl-5 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
                {data
                    .filter((element) => element) // Remove undefined/null items
                    .map((element) => (
                        <DashboardCard key={element.id} element={element} />
                    ))}
            </div>
        </>
    );
};

export default MainDashboard;
