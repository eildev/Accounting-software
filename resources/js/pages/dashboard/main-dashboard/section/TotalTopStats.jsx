import DashboardCard from "../../../../components/card/DashboardCard";

// Data for dashboard cards, contains information for each card
const data = [
    {
        id: 1, // Unique ID for the card
        name: "Assets", // Name of the card
        value: 9102, // Value associated with the card
        icon: "solar:wallet-money-bold", // Icon to be displayed in the card
        stats: 5000, // Stats representing positive change
        color: "cyan", // Color for the card
    },
    {
        id: 2,
        name: "Liabilities",
        value: 27891,
        icon: "tabler:report-money",
        stats: -2000, // Stats representing negative change
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

const TotalTopStats = () => {
    return (
        <div className="row row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
            {/* Filtering and mapping through the data array to display DashboardCard for each item */}
            {data
                .filter((element) => element) // Remove undefined/null items
                .map((element) => (
                    // DashboardCard component for each element in the data array
                    <DashboardCard key={element.id} element={element} />
                ))}
        </div>
    );
};

export default TotalTopStats;
