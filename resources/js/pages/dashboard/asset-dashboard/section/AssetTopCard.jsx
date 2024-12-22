import DashboardCard from "../../../../components/card/DashboardCard";

const data = [
    {
        id: 1,
        title: "Bank Balance",
        value: 92137,
        icon: "solar:money-bag-bold", // Bank icon
    },
    {
        id: 2,
        title: "Cash Balance",
        value: 92140,
        icon: "solar:wallet-bold", // Wallet icon
    },
    {
        id: 3,
        title: "Fixed Asset",
        value: 92137,
        icon: "solar:home-bold", // Fixed assets/building icon
    },
    {
        id: 4,
        title: "Stock Value",
        value: 92138,
        icon: "solar:graph-up-bold", // Stock/investment trend icon
    },
    {
        id: 5,
        title: "Receivable Amount",
        value: 92137,
        icon: "solar:card-recive-bold", // Receivable card icon
    },
    {
        id: 6,
        title: "Opening Capital",
        value: 92137,
        icon: "solar:wallet-bold", // Coins or capital icon
    },
];


const AssetTopCard = () => {
    return (
        <div className="row row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
            {data.map((item) => (
                <DashboardCard key={item.id} element={item}></DashboardCard>
            ))}
        </div>
    );
};

export default AssetTopCard;
