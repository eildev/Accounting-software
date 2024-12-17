import { Icon } from "@iconify/react";
import React from "react";

const DashboardCard = ({ element = {} }) => {
    const { name, value, icon, stats, id, color } = element || {};
    return (
        <div className="col">
            <div
                className={`card shadow-none border bg-gradient-start-${id} h-100`}
            >
                <div className="card-body p-20">
                    <div className="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p className="fw-medium text-primary-light mb-1">
                                {name || "N/A"}
                            </p>
                            <h6 className="mb-0">{value || 0}</h6>
                        </div>
                        <div
                            className={`w-50-px h-50-px bg-${
                                color ?? "cyan"
                            } rounded-circle d-flex justify-content-center align-items-center`}
                        >
                            <Icon
                                icon={icon || "gridicons:multiple-users"}
                                className="text-white text-2xl mb-0"
                            />
                        </div>
                    </div>
                    <p className="fw-medium text-xs text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                        <span
                            className={`d-inline-flex align-items-center gap-1 ${
                                stats > 0
                                    ? "text-success-main"
                                    : "text-danger-main"
                            }`}
                        >
                            <Icon
                                icon={
                                    stats > 0
                                        ? "bxs:up-arrow"
                                        : "bxs:down-arrow"
                                }
                                className="text-xs"
                            />
                            {stats ?? 0}
                        </span>
                        Last 30 days {name}
                    </p>
                </div>
            </div>
        </div>
    );
};

export default DashboardCard;
