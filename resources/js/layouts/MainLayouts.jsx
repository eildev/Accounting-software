import React, { useEffect, useState } from "react";
import { Outlet, useLocation } from "react-router-dom";
import Footer from "./Footer";
import Sidebar from "./Sidebar";
import Navbar from "./Navbar";
import RouteScrollToTop from "../helper/RouteScrollToTop";

const MainLayouts = () => {
    let [sidebarActive, seSidebarActive] = useState(false);
    let [mobileMenu, setMobileMenu] = useState(false);
    const location = useLocation();

    useEffect(() => {
        // Function to handle dropdown clicks
        const handleDropdownClick = (event) => {
            event.preventDefault();
            const clickedLink = event.currentTarget;
            const clickedDropdown = clickedLink.closest(".dropdown");

            if (!clickedDropdown) return;

            const isActive = clickedDropdown.classList.contains("open");

            // Close all dropdowns
            const allDropdowns = document.querySelectorAll(
                ".sidebar-menu .dropdown"
            );
            allDropdowns.forEach((dropdown) => {
                dropdown.classList.remove("open");
            });

            // Toggle the clicked dropdown
            if (!isActive) {
                clickedDropdown.classList.add("open");
            }
        };

        // Attach click event listeners to all dropdown triggers
        const dropdownTriggers = document.querySelectorAll(
            ".sidebar-menu .dropdown > a, .sidebar-menu .dropdown > Link"
        );

        dropdownTriggers.forEach((trigger) => {
            trigger.addEventListener("click", handleDropdownClick);
        });

        // Function to open submenu based on current route
        const openActiveDropdown = () => {
            const allDropdowns = document.querySelectorAll(
                ".sidebar-menu .dropdown"
            );
            allDropdowns.forEach((dropdown) => {
                const submenuLinks = dropdown.querySelectorAll(
                    ".sidebar-submenu li a"
                );
                submenuLinks.forEach((link) => {
                    if (
                        link.getAttribute("href") === location.pathname ||
                        link.getAttribute("to") === location.pathname
                    ) {
                        dropdown.classList.add("open");
                    }
                });
            });
        };

        // Open the submenu that contains the open route
        openActiveDropdown();

        // Cleanup event listeners on unmount
        return () => {
            dropdownTriggers.forEach((trigger) => {
                trigger.removeEventListener("click", handleDropdownClick);
            });
        };
    }, [location.pathname]);

    let sidebarControl = () => {
        seSidebarActive(!sidebarActive);
    };

    let mobileMenuControl = () => {
        setMobileMenu(!mobileMenu);
    };

    return (
        <>
            <RouteScrollToTop />
            <section className={mobileMenu ? "overlay active" : "overlay "}>
                <Sidebar
                    sidebarActive={sidebarActive}
                    mobileMenuControl={mobileMenuControl}
                    mobileMenu={mobileMenu}
                />
                <main
                    className={
                        sidebarActive
                            ? "dashboard-main active"
                            : "dashboard-main"
                    }
                >
                    <Navbar
                        sidebarControl={sidebarControl}
                        sidebarActive={sidebarActive}
                        mobileMenuControl={mobileMenuControl}
                    />
                    <div className="dashboard-main-body">
                        <Outlet />
                    </div>
                    <Footer />
                </main>
            </section>
        </>
    );
};

export default MainLayouts;
