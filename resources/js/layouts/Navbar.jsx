// Import necessary modules and components
import ThemeToggleButton from "../helper/ThemeToggleButton"; // Theme toggle button for light/dark mode
import Profile from "../components/nav-dropdownd/Profile"; // Profile dropdown component
import Notification from "../components/nav-dropdownd/Notification"; // Notification dropdown component
import ToggleButtonAndSearchBar from "../components/navbar/ToggleButtonAndSearchBar"; // Component for sidebar toggle and search bar

// Navbar component definition
const Navbar = ({ sidebarControl, sidebarActive, mobileMenuControl }) => {
    return (
        <div className="navbar-header"> {/* Main container for navbar */}
            <div className="row align-items-center justify-content-between"> {/* Layout for left and right sections */}
                <div className="col-auto"> {/* Left section of the navbar */}
                    {/* Toggle button and search bar component */}
                    <ToggleButtonAndSearchBar
                        sidebarControl={sidebarControl} // Function to control sidebar
                        sidebarActive={sidebarActive}   // Sidebar active state
                        mobileMenuControl={mobileMenuControl} // Function to control mobile menu
                    />
                </div>

                <div className="col-auto"> {/* Right section of the navbar */}
                    <div className="d-flex flex-wrap align-items-center gap-3"> {/* Flex container for icons */}
                        {/* Theme toggle button component */}
                        <ThemeToggleButton />

                        {/* Notification dropdown component */}
                        <Notification />
                        {/* Notification dropdown end */}

                        {/* Profile dropdown component */}
                        <Profile />
                        {/* Profile dropdown end */}
                    </div>
                </div>
            </div>
        </div>
    );
};

// Export the Navbar component to be used in other parts of the app
export default Navbar;
