import { Icon } from "@iconify/react";
import { Link, NavLink } from "react-router-dom";

const Sidebar = ({ sidebarActive, mobileMenuControl, mobileMenu }) => {
    return (
        <aside
            className={
                sidebarActive
                    ? "sidebar active "
                    : mobileMenu
                    ? "sidebar sidebar-open"
                    : "sidebar"
            }
        >
            <button
                onClick={mobileMenuControl}
                type="button"
                className="sidebar-close-btn"
            >
                <Icon icon="radix-icons:cross-2" />
            </button>
            <div>
                <Link to="/" className="sidebar-logo">
                    <img
                        src="assets/images/logo.png"
                        alt="site logo"
                        className="light-logo"
                    />
                    <img
                        src="assets/images/logo-light.png"
                        alt="site logo"
                        className="dark-logo"
                    />
                    <img
                        src="assets/images/logo-icon.png"
                        alt="site logo"
                        className="logo-icon"
                    />
                </Link>
            </div>
            <div className="sidebar-menu-area">
                <ul className="sidebar-menu" id="sidebar-menu">
                    <li className="dropdown">
                        <Link to="#">
                            <Icon
                                icon="solar:home-smile-angle-outline"
                                className="menu-icon"
                            />
                            <span>Dashboard</span>
                        </Link>
                        <ul className="sidebar-submenu">
                            <li>
                                <NavLink
                                    to="/"
                                    className={(navData) =>
                                        navData.isActive ? "active-page" : ""
                                    }
                                >
                                    <i className="ri-circle-fill circle-icon text-primary-600 w-auto" />
                                    Main Dashboard
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    to="/sale-dashboard"
                                    className={(navData) =>
                                        navData.isActive ? "active-page" : ""
                                    }
                                >
                                    <i className="ri-circle-fill circle-icon text-warning-main w-auto" />{" "}
                                    Sale Dashboard
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    to="/asset-dashboard"
                                    className={(navData) =>
                                        navData.isActive ? "active-page" : ""
                                    }
                                >
                                    <i className="ri-circle-fill circle-icon text-warning-main w-auto" />{" "}
                                    Asset Dashboard
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    to="/expense-dashboard"
                                    className={(navData) =>
                                        navData.isActive ? "active-page" : ""
                                    }
                                >
                                    <i className="ri-circle-fill circle-icon text-warning-main w-auto" />{" "}
                                    Expense Dashboard
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    to="/payroll-dashboard"
                                    className={(navData) =>
                                        navData.isActive ? "active-page" : ""
                                    }
                                >
                                    <i className="ri-circle-fill circle-icon text-warning-main w-auto" />{" "}
                                    Payroll Dashboard
                                </NavLink>
                            </li>
                        </ul>
                    </li>

                    <li className="sidebar-menu-group-title">Application</li>
                </ul>
            </div>
        </aside>
    );
};

export default Sidebar;
