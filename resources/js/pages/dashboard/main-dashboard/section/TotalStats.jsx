import DashboardCard from "../../../../components/card/DashboardCard";

const data = [
    {
        id: 1, // Unique ID for the card
        title: "Assets", // Name of the card
        value: 9102, // Value associated with the card
        icon: "solar:wallet-money-bold", // Icon to be displayed in the card
        stats: 5000, // Stats representing positive change
        color: "cyan", // Color for the card
    },
    {
        id: 2,
        title: "Liabilities",
        value: 27891,
        icon: "tabler:report-money",
        stats: -2000, // Stats representing negative change
        color: "purple",
    },
    {
        id: 3,
        title: "Income",
        value: 46828,
        icon: "solar:money-bag-bold",
        stats: 7000,
        color: "info",
    },
    {
        id: 4,
        title: "Expanse",
        value: 34258,
        icon: "solar:card-recive-bold",
        stats: -400,
        color: "success-main",
    },
];

const TotalStats = () => {
    return (
        <div className="col-xl-7">
            <div className="row gy-4">
                {/* Filtering and mapping through the data array to display DashboardCard for each item */}
                {data
                    .filter((element) => element) // Remove undefined/null items
                    .map((element) => (
                        // DashboardCard component for each element in the data array
                        <DashboardCard key={element.id} element={element} />
                    ))}
            </div>
        </div>
    );
};

export default TotalStats;
