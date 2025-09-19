<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Base Styles from index.html for consistency */
:root {
    --primary-color: #2a5f8a;
    --secondary-color: #e67e22;
    --accent-color: #3498db;
    --text-color: #333;
    --light-text: #777;
    --bg-light: #f9f9f9;
    --white: #ffffff;
    --dark-blue: #1a3a5f;
    --border-color: #ddd;
    --shadow-light: rgba(0,0,0,0.1);
    --shadow-medium: rgba(0,0,0,0.2);
    --success-color: #28a745;
    --danger-color: #dc3545;
    --info-color: #17a2b8;
    --warning-color: #ffc107;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Open Sans', sans-serif;
    color: var(--text-color);
    line-height: 1.6;
    background-color: var(--bg-light);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

a {
    text-decoration: none;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

a:hover {
    color: var(--secondary-color);
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.btn:hover {
    background-color: var(--dark-blue);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.donate-btn {
    background-color: var(--secondary-color);
}

.donate-btn:hover {
    background-color: #d35400;
}

h1, h2, h3, h4 {
    font-family: 'Roboto', sans-serif;
    font-weight: 500;
    margin-bottom: 15px;
    color: var(--primary-color);
}

h2:after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background-color: var(--secondary-color);
    margin-top: 10px;
    border-radius: 2px;
}

/* --- Login Page Styles (if applicable, though not directly in admin.php) --- */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(to bottom right, var(--primary-color), var(--dark-blue));
}

.login-box {
    background-color: var(--white);
    padding: 40px;
    border-radius: 10px; /* Slightly more rounded */
    box-shadow: 0 10px 30px var(--shadow-medium); /* Stronger shadow */
    text-align: center;
    width: 100%;
    max-width: 450px; /* Slightly wider */
    animation: fadeIn 0.6s ease-out;
}

.login-logo {
    height: 90px; /* Larger logo */
    border-radius: 50%;
    margin-bottom: 25px;
    border: 3px solid var(--secondary-color); /* Thicker border */
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.login-box h2 {
    margin-bottom: 30px;
    color: var(--primary-color);
    font-size: 2.2rem;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-color);
    font-size: 0.95rem;
}

.form-group input[type="text"],
.form-group input[type="password"],
.form-group input[type="email"],
.form-group input[type="number"],
.form-group input[type="date"],
.form-group input[type="file"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 15px; /* More padding */
    border: 1px solid var(--border-color);
    border-radius: 6px; /* Slightly more rounded */
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    background-color: var(--bg-light); /* Light background for inputs */
}

.form-group input[type="text"]:focus,
.form-group input[type="password"]:focus,
.form-group input[type="email"]:focus,
.form-group input[type="number"]:focus,
.form-group input[type="date"]:focus,
.form-group input[type="file"]:focus,
.form-group select:focus,

.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(42, 95, 138, 0.3); /* Stronger focus shadow */
    outline: none;
    background-color: var(--white); /* White background on focus */
}

.login-box .btn {
    width: 100%;
    padding: 14px; /* Larger button */
    font-size: 1.2rem;
    margin-top: 15px;
}

.login-message {
    margin-top: 25px;
    color: var(--danger-color);
    font-weight: 700;
    font-size: 1.1rem;
}

/* --- Admin Dashboard Layout --- */
.admin-wrapper {
    display: flex;
    min-height: 100vh;
    background-color: var(--bg-light);
}

.admin-sidebar {
    width: 280px; /* Wider sidebar */
    background-color: var(--dark-blue);
    color: var(--white);
    padding: 25px 0; /* More vertical padding */
    box-shadow: 3px 0 15px var(--shadow-medium); /* Stronger shadow */
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: 100vh; /* Full height */
    overflow-y: auto; /* Scrollable if content overflows */
    z-index: 1000; /* Ensure it's above other content */
}

.sidebar-header {
    text-align: center;
    margin-bottom: 40px; /* More space */
    padding: 0 20px;
}

.sidebar-logo {
    height: 80px; /* Larger logo */
    border-radius: 50%;
    margin-bottom: 15px;
    border: 3px solid var(--secondary-color);
    box-shadow: 0 0 10px rgba(255,255,255,0.2);
}

.sidebar-header h3 {
    color: var(--white);
    font-size: 1.8rem; /* Larger title */
    margin-top: 10px;
    letter-spacing: 1px;
}

.sidebar-nav ul {
    list-style: none;
    padding: 0 20px; /* Padding for list items */
}

.sidebar-nav ul li {
    margin-bottom: 8px; /* Slightly less space between items */
}

.sidebar-nav ul li a {
    display: flex;
    align-items: center;
    padding: 14px 18px; /* More padding */
    color: rgba(255,255,255,0.85); /* Lighter text */
    border-radius: 6px; /* Rounded corners */
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 1.05rem;
}

.sidebar-nav ul li a i {
    margin-right: 12px; /* More space for icon */
    font-size: 1.2rem;
    color: var(--accent-color); /* Accent color for icons */
}

.sidebar-nav ul li a:hover,
.sidebar-nav ul li a.active {
    background-color: var(--primary-color);
    color: var(--white);
    transform: translateX(8px); /* More pronounced slide effect */
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.sidebar-nav ul li a.active i {
    color: var(--white); /* White icon when active */
}

.admin-main-content {
    flex-grow: 1;
    padding: 30px 40px; /* More padding */
    background-color: var(--bg-light);
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px; /* More space */
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
    background-color: var(--white); /* White background for header */
    padding: 20px 30px;
    margin: -30px -40px 40px -40px; /* Extend to edges of main content area */
    box-shadow: 0 2px 10px var(--shadow-light);
    border-radius: 8px;
}

.admin-header h1 {
    margin: 0;
    font-size: 2.5rem; /* Larger heading */
    color: var(--dark-blue);
}

.header-actions .btn {
    margin-left: 20px; /* More space */
    padding: 12px 25px; /* Larger buttons */
    font-size: 1rem;
}

/* --- Section Styles --- */
.admin-section {
    background-color: var(--white);
    padding: 35px; /* More padding */
    border-radius: 10px; /* More rounded */
    box-shadow: 0 5px 20px var(--shadow-light); /* Stronger shadow */
    margin-bottom: 30px;
    display: none; /* Hidden by default, shown by JS */
    animation: fadeIn 0.6s ease-out; /* Slower fade-in */
}

.admin-section.active {
    display: block;
}

/* NEW: Full-screen section style */
/* Removed .admin-section.fullscreen to prevent full-screen behavior */


.admin-section h2 {
    display: flex;
    align-items: center;
    color: var(--dark-blue);
    font-size: 2.2rem;
    margin-bottom: 25px;
}

.admin-section h2 i {
    margin-right: 15px; /* More space */
    color: var(--secondary-color);
    font-size: 2rem; /* Larger icon */
}

.admin-section h2:after {
    content: '';
    display: block;
    width: 70px; /* Wider underline */
    height: 4px;
    background-color: var(--accent-color);
    margin-top: 10px;
    border-radius: 2px;
}

/* Dashboard Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Larger min-width */
    gap: 25px; /* More space */
    margin-bottom: 35px;
}

.stat-card {
    background-color: var(--white);
    padding: 30px; /* More padding */
    border-radius: 10px; /* More rounded */
    box-shadow: 0 4px 15px var(--shadow-light); /* Stronger shadow */
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-bottom: 5px solid var(--primary-color); /* Thicker border */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.stat-card:hover {
    transform: translateY(-8px); /* More pronounced lift */
    box-shadow: 0 10px 30px var(--shadow-medium);
}

.stat-card .icon-large {
    font-size: 4rem; /* Larger icon */
    color: var(--primary-color);
    margin-bottom: 20px;
}

.stat-card:nth-child(2) .icon-large { color: var(--secondary-color); }
.stat-card:nth-child(3) .icon-large { color: var(--accent-color); }
/* Removed Most Supported Cause stat card */

.stat-card h3 {
    font-size: 1.4rem; /* Larger text */
    color: var(--light-text);
    margin-bottom: 12px;
}

.stat-card .stat-number {
    font-size: 3.2rem; /* Larger number */
    font-weight: 700;
    color: var(--secondary-color);
}
.stat-card .stat-label {
    font-size: 1.8rem; /* Larger label */
    font-weight: 700;
    color: var(--secondary-color);
}


.chart-placeholder {
    background-color: var(--bg-light);
    padding: 30px; /* More padding */
    border-radius: 10px;
    text-align: center;
    border: 2px dashed var(--border-color); /* Thicker dashed border */
    box-shadow: inset 0 1px 5px rgba(0,0,0,0.05);
}

.chart-placeholder img {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
    margin-top: 20px;
    box-shadow: var(--shadow-medium); /* Stronger shadow for image */
}

/* Data Tables */
.filter-bar {
    display: flex;
    gap: 20px; /* More space */
    margin-bottom: 30px;
    flex-wrap: wrap;
    align-items: center;
    background-color: var(--white); /* White background */
    padding: 20px; /* More padding */
    border-radius: 10px;
    box-shadow: 0 2px 10px var(--shadow-light); /* Stronger shadow */
}

.filter-bar input,
.filter-bar select {
    padding: 12px 15px; /* More padding */
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    flex: 1;
    min-width: 180px; /* Larger min-width */
    background-color: var(--bg-light);
}

.filter-bar .search-input {
    flex-grow: 3; /* More growth for search */
    min-width: 300px; /* Larger min-width */
}

.filter-bar .btn {
    padding: 12px 25px;
    font-size: 1rem;
}

.table-responsive {
    overflow-x: auto;
    border-radius: 10px;
    box-shadow: 0 5px 20px var(--shadow-light); /* Stronger shadow */
}

.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 0;
    background-color: var(--white);
    
}

.data-table th,
.data-table td {
    padding: 18px 25px; /* More padding */
    border-bottom: 1px solid var(--border-color);
    text-align: left;
}

.data-table th {
    background-color: var(--primary-color);
    color: var(--white);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.95rem; /* Slightly larger font */
    position: sticky;
    top: 0;
    z-index: 1;
}

.data-table thead tr:first-child th:first-child {
    border-top-left-radius: 10px; /* Match table-responsive border-radius */
}

.data-table thead tr:first-child th:last-child {
    border-top-right-radius: 10px; /* Match table-responsive border-radius */
}

.data-table tbody tr:nth-child(even) {
    background-color: var(--bg-light);
}

.data-table tbody tr:hover {
    background-color: #e0eaf5; /* Lighter hover color */
    cursor: pointer;
}

.data-table td:last-child {
    white-space: nowrap;
}

.action-btn {
    padding: 9px 14px; /* Slightly larger */
    border: none;
    border-radius: 5px; /* Slightly more rounded */
    cursor: pointer;
    font-size: 0.9rem;
    margin-right: 8px; /* More space */
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.action-btn i {
    margin-right: 6px;
}

.view-btn {
    background-color: var(--accent-color);
    color: white;
}

.view-btn:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.edit-btn {
    background-color: var(--secondary-color);
    color: white;
}

.edit-btn:hover {
    background-color: #d35400;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.delete-btn {
    background-color: var(--danger-color);
    color: white;
}

.delete-btn:hover {
    background-color: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Campaign Summary */
.campaign-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Larger min-width */
    gap: 25px;
    margin-bottom: 35px;
}

.summary-card {
    background-color: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px var(--shadow-light);
    border-left: 6px solid var(--primary-color); /* Thicker border */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px var(--shadow-medium);
}

.summary-card h3 {
    font-size: 1.6rem; /* Larger heading */
    margin-bottom: 15px;
    color: var(--dark-blue);
}

.summary-card p {
    font-size: 1.1rem;
    color: var(--text-color);
    margin-bottom: 8px;
}

.summary-card .stat-number {
    font-size: 2.5rem; /* Larger number */
    font-weight: 700;
    color: var(--secondary-color);
}

.progress-bar-container {
    background-color: var(--border-color); /* Lighter background */
    border-radius: 8px; /* More rounded */
    height: 22px; /* Taller bar */
    margin: 15px 0;
    overflow: hidden;
    box-shadow: inset 0 1px 4px rgba(0,0,0,0.15); /* Stronger inset shadow */
}

.progress-bar {
    background-color: var(--secondary-color);
    height: 100%;
    border-radius: 8px;
    transition: width 0.6s ease-in-out; /* Slower transition */
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700; /* Bolder text */
    font-size: 1rem; /* Larger text */
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

/* Content Options Grid */
.content-options-grid,
.email-options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Larger min-width */
    gap: 25px;
}

.option-card {
    background-color: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px var(--shadow-light);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-bottom: 5px solid var(--accent-color);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.option-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px var(--shadow-medium);
}

.option-card i {
    font-size: 3.5rem; /* Larger icon */
    color: var(--primary-color);
    margin-bottom: 20px;
}

.option-card h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: var(--dark-blue);
}

.option-card p {
    color: var(--light-text);
    margin-bottom: 25px; /* More space */
    font-size: 1.05rem;
}

.option-card .btn {
    margin: 8px; /* More margin */
    padding: 10px 20px;
    font-size: 0.95rem;
}

/* Export Options */
.export-options {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    align-items: flex-end;
    background-color: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px var(--shadow-light);
}

.export-options .form-group {
    margin-bottom: 0;
    flex: 1;
    min-width: 200px; /* Larger min-width */
}

.export-options input,
.export-options select {
    width: 100%;
    padding: 12px 15px;
    border-radius: 6px;
    background-color: var(--bg-light);
}

.export-options .btn {
    padding: 12px 25px;
    font-size: 1rem;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.75); /* Darker overlay */
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 35px; /* More padding */
    border-radius: 10px;
    width: 95%; /* Wider on small screens */
    max-width: 650px; /* Larger max-width */
    box-shadow: 0 10px 40px rgba(0,0,0,0.5); /* Stronger shadow */
    position: relative;
    animation: fadeInScale 0.4s ease-out; /* New animation */
}

@keyframes fadeInScale {
    from { opacity: 0; transform: translateY(-30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.modal-content h3 {
    color: var(--primary-color);
    margin-bottom: 25px; /* More space */
    font-size: 2.2rem;
    display: flex;
    align-items: center;
}

.modal-content h3 i {
    margin-right: 12px;
    color: var(--secondary-color);
    font-size: 2.2rem;
}

.modal-content p {
    color: var(--text-color);
    line-height: 1.7;
    margin-bottom: 12px;
    font-size: 1.05rem;
}

.close-button {
    color: #888; /* Softer color */
    position: absolute;
    top: 15px;
    right: 25px;
    font-size: 40px; /* Larger close button */
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.close-button:hover,
.close-button:focus {
    color: var(--danger-color); /* Red on hover */
    text-decoration: none;
}

/* Styled Form (for add/edit sections) */
.styled-form {
    background-color: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px var(--shadow-light);
    margin-top: 25px;
}

.styled-form h3 {
    color: var(--dark-blue);
    font-size: 1.8rem;
    margin-bottom: 25px;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 10px;
}

.styled-form .form-group {
    margin-bottom: 20px;
}

.styled-form .form-group label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 8px;
    display: block;
}

.styled-form .form-group input[type="text"],
.styled-form .form-group input[type="date"],
.styled-form .form-group input[type="file"],
.styled-form .form-group textarea,
.styled-form .form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    background-color: var(--bg-light);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.styled-form .form-group input[type="file"] {
    padding: 8px 15px; /* Adjust padding for file input */
}

.styled-form .form-group input:focus,
.styled-form .form-group textarea:focus,
.styled-form .form-group select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(42, 95, 138, 0.3);
    outline: none;
    background-color: var(--white);
}

.styled-form .btn {
    padding: 12px 25px;
    font-size: 1.05rem;
    margin-top: 15px;
}

/* Item List (for news, publications, stories) */
.item-list {
    margin-top: 40px; /* More space */
    border-top: 1px solid var(--border-color);
    padding-top: 30px; /* More padding */
}

.item-list h3 {
    color: var(--dark-blue);
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.item-card {
    background-color: var(--white);
    padding: 20px; /* More padding */
    border-radius: 8px;
    margin-bottom: 12px; /* More space */
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px var(--shadow-light); /* Stronger shadow */
    border-left: 5px solid var(--accent-color);
    transition: all 0.3s ease;
}

.item-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.item-card span {
    font-weight: 600;
    color: var(--text-color);
    flex-grow: 1;
    font-size: 1.15rem; /* Larger text */
}

.item-card .action-btn {
    margin-left: 15px; /* More space */
    padding: 8px 12px;
    font-size: 0.85rem;
}

/* What We Do Admin Section */
#whatWeDoAdminSection {
    background-color: var(--white);
    padding: 35px;
    border-radius: 10px;
    box-shadow: 0 5px 20px var(--shadow-light);
    margin-bottom: 30px;
}

#whatWeDoAdminSection h2 {
    display: flex;
    align-items: center;
    color: var(--dark-blue);
    font-size: 2.2rem;
    margin-bottom: 25px;
}

#whatWeDoAdminSection h2 i {
    margin-right: 15px;
    color: var(--secondary-color);
    font-size: 2rem;
}

#whatWeDoAdminSection h2:after {
    content: '';
    display: block;
    width: 70px;
    height: 4px;
    background-color: var(--accent-color);
    margin-top: 10px;
    border-radius: 2px;
}

#whatWeDoAdminSection .form-group {
    margin-bottom: 20px;
}

#whatWeDoAdminSection .form-group label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 8px;
    display: block;
}

#whatWeDoAdminSection .form-group input[type="text"],
#whatWeDoAdminSection .form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    background-color: var(--bg-light);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

#whatWeDoAdminSection .form-group input:focus,
#whatWeDoAdminSection .form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(42, 95, 138, 0.3);
    outline: none;
    background-color: var(--white);
}

#whatWeDoAdminSection .btn {
    padding: 12px 25px;
    font-size: 1.05rem;
    margin-top: 15px;
}

/* NEW: Album Card Styles */
.album-card {
    background-color: var(--white);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 12px;
    display: flex;
    flex-direction: column; /* Stack content vertically */
    align-items: center;
    box-shadow: 0 2px 8px var(--shadow-light);
    border-left: 5px solid var(--accent-color);
    transition: all 0.3s ease;
    text-align: center;
    width: 220px; /* Fixed width for album cards */
    flex-shrink: 0; /* Prevent shrinking */
}

.album-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.album-card img {
    width: 100%; /* Make image fill card width */
    height: 150px; /* Fixed height for cover image */
    object-fit: cover; /* Cover the area */
    border-radius: 4px;
    margin-bottom: 15px;
}

.album-card h4 {
    font-size: 1.2rem;
    margin-bottom: 8px;
    color: var(--dark-blue);
}

.album-card p {
    font-size: 0.9rem;
    color: var(--light-text);
    margin-bottom: 15px;
    flex-grow: 1; /* Allow description to take space */
}

.album-card .album-actions {
    display: flex;
    gap: 10px;
    margin-top: auto; /* Push actions to bottom */
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
    .admin-sidebar {
        width: 220px; /* Slightly narrower sidebar */
        padding: 20px 0;
    }
    .sidebar-nav ul li a {
        font-size: 1rem;
        padding: 12px 15px;
    }
    .sidebar-nav ul li a i {
        font-size: 1.1rem;
        margin-right: 10px;
    }
    .admin-main-content {
        padding: 25px 30px;
    }
    .admin-header {
        margin: -25px -30px 30px -30px;
        padding: 15px 25px;
    }
    .admin-header h1 {
        font-size: 2.2rem;
    }
    .admin-section {
        padding: 30px;
    }
    .admin-section h2 {
        font-size: 2rem;
    }
    .stats-grid,
    .campaign-summary,
    .content-options-grid,
    .email-options-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .filter-bar {
        gap: 15px;
        padding: 15px;
    }
    .data-table th,
    .data-table td {
        padding: 15px 20px;
    }
}

@media (max-width: 768px) {
    .admin-wrapper {
        flex-direction: column;
    }

    .admin-sidebar {
        width: 100%;
        height: auto;
        padding: 15px 20px;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px var(--shadow-medium);
        position: relative;
        overflow-y: visible;
    }

    .sidebar-header {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        flex-grow: 1;
        justify-content: flex-start;
    }

    .sidebar-header h3 {
        display: none; /* Hide text on small screens */
    }

    .sidebar-logo {
        height: 60px;
        margin-bottom: 0;
        margin-right: 15px;
    }

    .sidebar-nav {
        display: none; /* Hide full nav by default on small screens */
        width: 100%;
        position: absolute;
        top: 90px; /* Adjust based on header height */
        left: 0;
        background-color: var(--dark-blue);
        z-index: 999;
        box-shadow: 0 5px 15px var(--shadow-medium);
        border-radius: 0 0 10px 10px;
        padding-bottom: 10px;
    }

    .sidebar-nav.active {
        display: block;
    }

    .sidebar-nav ul {
        flex-direction: column;
        padding: 10px 0;
    }

    .sidebar-nav ul li {
        margin-bottom: 5px;
    }
    .sidebar-nav ul li a {
        padding: 10px 20px;
        font-size: 1rem;
    }

    .admin-main-content {
        padding: 20px;
    }

    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
        margin: -20px -20px 30px -20px;
        padding: 15px 20px;
    }

    .admin-header h1 {
        font-size: 2rem;
    }

    .header-actions {
        width: 100%;
        display: flex;
        justify-content: space-around;
    }

    .header-actions .btn {
        margin: 0 5px;
        flex: 1;
        padding: 10px 15px;
        font-size: 0.9rem;
    }

    .stats-grid,
    .campaign-summary,
    .content-options-grid,
    .email-options-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }

    .filter-bar input,
    .filter-bar select,
    .filter-bar button {
        width: 100%;
        min-width: unset;
    }

    .export-options {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    .export-options .form-group {
        min-width: unset;
    }

    .item-card {
        flex-direction: column; /* Stack on small screens */
        align-items: flex-start; /* Align items to start */
        padding: 15px;
    }

    .item-card span {
        margin-bottom: 10px; /* Add space below text */
        font-size: 1.1rem;
    }

    .item-card .action-btn {
        margin-left: 0; /* Remove left margin */
        width: 100%; /* Full width button */
        margin-top: 8px; /* Space between buttons */
    }

    .modal-content {
        padding: 25px;
    }
    .modal-content h3 {
        font-size: 1.8rem;
    }
    .modal-content h3 i {
        font-size: 1.8rem;
    }
    .close-button {
        font-size: 35px;
    }
}

@media (max-width: 480px) {
    .admin-main-content {
        padding: 15px;
    }
    .admin-header {
        margin: -15px -15px 25px -15px;
        padding: 10px 15px;
    }
    .admin-header h1 {
        font-size: 1.8rem;
    }
    .admin-section {
        padding: 20px;
    }
    .admin-section h2 {
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    .admin-section h2 i {
        font-size: 1.6rem;
    }
    .stat-card {
        padding: 25px;
    }
    .stat-card .icon-large {
        font-size: 3.5rem;
    }
    .stat-card .stat-number {
        font-size: 2.8rem;
    }
    .stat-card .stat-label {
        font-size: 1.4rem;
    }
    .data-table th,
    .data-table td {
        padding: 12px 15px;
        font-size: 0.85rem;
    }
    .action-btn {
        padding: 7px 10px;
        font-size: 0.8rem;
    }
    .styled-form {
        padding: 20px;
    }
    .styled-form h3 {
        font-size: 1.5rem;
    }
    .item-card span {
        font-size: 1rem;
    }
}
.photos-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.photos-grid .photo-item {
    width: 150px;        /* fixed width */
    height: 150px;       /* fixed height */
    overflow: hidden;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.photos-grid .photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;   /* crops/resizes image to fit the box */
    display: block;
}
.photos-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
}

.photo-item {
    width: 150px;
    height: 150px;
    overflow: hidden;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
    cursor: pointer;
}

.photo-item:hover img {
    width: 50vw;      /* expand width to half screen */
    height: 50vh;     /* expand height proportionally */
    z-index: 100;     /* appear above others */
    position: fixed;  /* fix position so it doesn’t push other photos */
    top: 25%;         /* center vertically */
    left: 25%;        /* center horizontally */
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.7);
}


</style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h3> Admin</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#dashboard" class="active" data-section="dashboardStatsSection"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#donations" data-section="donations"><i class="fas fa-hand-holding-heart"></i> Donations</a></li>
                    <li><a href="#campaigns" data-section="campaigns"><i class="fas fa-chart-line"></i> Campaigns</a></li>
                    <li><a href="#addNews" data-section="addNewsSection"><i class="fas fa-newspaper"></i> News Articles</a></li>
                    <li><a href="#addPublication" data-section="addPublicationSection"><i class="fas fa-book"></i> Notifications</a></li>
                    <li><a href="#successStoriesSection" data-section="successStoriesSection"><i class="fas fa-trophy"></i> What we Do</a></li>
                    <!-- NEW: Applications Link -->
                    <li><a href="#applications" data-section="applicationsSection"><i class="fas fa-file-alt"></i> Applications</a></li>
                    <!-- NEW: Photo Gallery Link -->
                    <li><a href="#photoGallery" data-section="photoGallerySection"><i class="fas fa-images"></i> Photo Gallery</a></li>
                    <li><a href="#export" data-section="export"><i class="fas fa-file-export"></i> Export Data</a></li>
                    <li><a href="#settings" data-section="settingsSection"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main-content">
            <header class="admin-header">
                <h1>Welcome, Admin!</h1>
                <div class="header-actions">
                    <button id="logoutBtn" class="btn">Logout</button>
                </div>
            </header>

            <!-- Dashboard Stats Section -->
            <section class="admin-section active" id="dashboardStatsSection">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard Overview</h2>
                <div class="stats-grid">
                    <!-- Total Donors -->
                    <div class="stat-card">
                        <i class="fas fa-users icon-large"></i>
                        <h3>Total Donors</h3>
                        <p class="stat-number" id="totalDonors">Loading...</p>
                    </div>

                    <!-- Total Amount Donated -->
                    <div class="stat-card">
                        <i class="fas fa-rupee-sign icon-large"></i>
                        <h3>Total ₹ Donated</h3>
                        <p class="stat-number" id="totalAmount">Loading...</p>
                    </div>

                    <!-- Removed Active Campaigns -->
                    <!-- Removed Most Supported Cause -->
                </div>
            </section>

            <!-- Donations Section -->
            <section id="donations" class="admin-section">
                <h2><i class="fas fa-hand-holding-heart"></i> Track & Manage Donations</h2>
                <div class="filter-bar">
                    <input type="text" placeholder="Search donations..." class="search-input">
                    <!-- Removed Cause Filter Select -->
                    <input type="date" class="filter-date">
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Donor Name</th>
                                <th>Amount (₹)</th>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Donor Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Donation data will be loaded dynamically here -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Campaigns Section -->
            <section id="campaigns" class="admin-section">
                <h2><i class="fas fa-chart-line"></i> Monitor Campaign Impact</h2>
                <div class="campaign-summary">
                    <div class="summary-card">
                        <h3>Campaign</h3>
                        <p>Target: ₹ <span id="campaignTarget">1,000,000</span></p>
                        <p>Raised: ₹ <span id="campaignRaised">0</span></p>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 0%;" id="campaignProgressBar">0%</div>
                        </div>
                        <p><span id="campaignAchievedPercentage">0</span>% Achieved</p>
                    </div>
                    
                </div>
                
            </section>

            <!-- Add News Section -->
            <section id="addNewsSection" class="admin-section">
                <h2><i class="fas fa-newspaper"></i> Manage News Articles</h2>
                <p>Use the form below to add new news articles, or manage existing ones.</p>
                
                <form id="addNewsForm" enctype="multipart/form-data" class="styled-form">
                    <h3>Add New Article</h3>
                    <div class="form-group">
                        <label for="newsTitle">Title:</label>
                        <input type="text" id="newsTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="newsContent">Content:</label>
                        <textarea id="newsContent" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newsDate">Published Date:</label>
                        <input type="date" id="newsDate" name="published_at" required>
                    </div>
                    <div class="form-group">
                        <label for="newsImage">Image:</label>
                        <input type="file" id="newsImage" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Upload News</button>
                </form>

                <div class="item-list">
                    <h3>Existing News Articles</h3>
                    <div id="newsList">
                        <!-- News articles will be loaded dynamically here -->
                        <p>Loading news...</p>
                    </div>
                </div>
            </section>

            <!-- Add Publication Section -->
            <section id="addPublicationSection" class="admin-section">
                <h2><i class="fas fa-book"></i> Manage Notifications</h2>
                <p>Use the form below to add new notifications.</p>
                
                <form id="addPublicationForm" enctype="multipart/form-data" method="post" class="styled-form">
                    <h3>Add New Notifiction</h3>
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Publish Date:</label>
                        <input type="date" name="published_at" required>
                    </div>

                    <div class="form-group">
                        <label>Upload PDF File:</label>
                        <input type="file" name="file" accept=".pdf" required>
                    </div>

                    <div class="form-group">
                        <label>Upload Cover Image:</label>
                        <input type="file" name="cover_image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Upload Notification</button>
                </form>

                <div class="item-list">
                    <h3>Existing Notifications</h3>
                    <div id="publicationList">
                        <!-- Publications will be loaded dynamically here -->
                        <p>Loading notifications...</p>
                    </div>
                </div>
            </section>

            <!-- Stories Section (Renamed to What We Do for clarity based on sidebar) -->
            <section id="storiesSection" class="admin-section">
                <h2><i class="fas fa-book-open"></i> Manage What We Do</h2>
                <p>Use the form below to add new "What We Do" items, or manage existing ones.</p>
                
                <form id="addStoryForm" enctype="multipart/form-data" class="styled-form">
                    <h3>Add New Program/Initiative</h3>
                    <div class="form-group">
                        <label for="storyTitle">Title:</label>
                        <input type="text" id="storyTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="storyContent">Description:</label>
                        <textarea id="storyContent" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="storyImage">Image:</label>
                        <input type="file" id="storyImage" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Add Program</button>
                </form>

                <div class="item-list">
                    <h3>Existing Programs/Initiatives</h3>
                    <div id="storiesList">
                        <!-- Stories (What We Do) will be loaded dynamically here -->
                        <p>Loading programs...</p>
                    </div>
                </div>
            </section>

            <!-- Success Stories Section -->
            <section id="successStoriesSection" class="admin-section">
                <h2><i class="fas fa-trophy"></i> Manage Success Stories</h2>
                <p>Use the form below to add new success stories, or manage existing ones.</p>
                
                <form id="addSuccessStoryForm" enctype="multipart/form-data" class="styled-form">
                    <h3>Add New Success Story</h3>
                    <div class="form-group">
                        <label for="successStoryTitle">Title:</label>
                        <input type="text" id="successStoryTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="successStoryContent">Content:</label>
                        <textarea id="successStoryContent" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="successStoryImage">Image:</label>
                        <input type="file" id="successStoryImage" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Upload Success Story</button>
                </form>

                <div class="item-list">
                    <h3>Existing Success Stories</h3>
                    <div id="successStoriesList">
                        <!-- Success Stories will be loaded dynamically here -->
                        <p>Loading success stories...</p>
                    </div>
                </div>
            </section>

            <!-- NEW: Applications Section -->
            <section id="applicationsSection" class="admin-section">
                <h2><i class="fas fa-file-alt"></i> Manage Applications</h2>
    <div class="filter-bar">
        <select id="notificationTitleDropdown" class="filter-select">
            <option value="">All Notifications</option>
            <!-- Notification titles will be populated dynamically -->
        </select>
        <input type="date" class="filter-date" id="applicationFilterDate">
    </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Notification Title</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Studying</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="applicationsTableBody">
                            <!-- Application data will be loaded dynamically here -->
                            <tr><td colspan="8">Loading applications...</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- NEW: Photo Gallery Section -->
            <section id="photoGallerySection" class="admin-section">
                <h2><i class="fas fa-images"></i> Manage Photo Gallery</h2>
                <p>Create new albums or add photos to existing ones.</p>
                
                <form id="addAlbumForm" enctype="multipart/form-data" class="styled-form">
                    <h3>Create New Photo Album</h3>
                    <div class="form-group">
                        <label for="albumTitle">Album Title:</label>
                        <input type="text" id="albumTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="albumDescription">Album Description:</label>
                        <textarea id="albumDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="albumCoverImage">Album Cover Image:</label>
                        <input type="file" id="albumCoverImage" name="cover_image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-plus-circle"></i> Create Album</button>
                </form>

                <form id="addPhotosToAlbumForm" enctype="multipart/form-data" class="styled-form" style="margin-top: 30px;">
                    <h3>Add Photos to Existing Album</h3>
                    <div class="form-group">
                        <label for="selectAlbum">Select Album:</label>
                        <select id="selectAlbum" name="album_id" required>
                            <option value="">-- Select an Album --</option>
                            <!-- Albums will be loaded here dynamically -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="albumPhotos">Select Photos (Multiple):</label>
                        <input type="file" id="albumPhotos" name="photos[]" accept="image/*" multiple required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Upload Photos to Album</button>
                </form>

                <div class="item-list">
                    <h3>Existing Photo Albums</h3>
                    <div id="albumList" style="display: flex; flex-wrap: wrap; gap: 20px;">
                        <!-- Albums will be loaded dynamically here -->
                        <p>Loading albums...</p>
                    </div>
                </div>
                <div id="albumPhotosContainer" class="photos-grid"></div>
                

            </section>


            <!-- Export Data Section -->
            <section id="export" class="admin-section">
                <h2><i class="fas fa-file-export"></i> Export Donation Data</h2>
                <p>Select criteria to export donation records.</p>
                <div class="export-options">
                    <div class="form-group">
                        <label for="exportStartDate">Start Date:</label>
                        <input type="date" id="exportStartDate">
                    </div>
                    <div class="form-group">
                        <label for="exportEndDate">End Date:</label>
                        <input type="date" id="exportEndDate">
                    </div>
                    <!-- Removed Export Cause Filter -->
                    <div class="form-group">
                        <label for="exportFormat">Format:</label>
                        <select id="exportFormat">
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <button class="btn donate-btn" id="triggerExportBtn"><i class="fas fa-download"></i> Export Data</button>
                </div>
            </section>

           

            <!-- Settings Section -->
            <section id="settingsSection" class="admin-section">
                <h2><i class="fas fa-cog"></i> General Settings</h2>
                <form id="settingsForm" enctype="multipart/form-data" class="styled-form" action="admin/settings.php" method="post">
                    <h3>Upload Logo</h3>
                    <div class="form-group">
                        <label for="logoUpload">Select Logo Image:</label>
                        <input type="file" id="logoUpload" name="logo" accept="image/*">
                        <small>Recommended size: 200x200 pixels</small>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-upload"></i> Upload Logo</button>
                </form>

                <hr style="margin: 30px 0; border-color: var(--border-color);">

                <form id="targetSettingsForm" class="styled-form">
                    <h3>Set Donation Target</h3>
                    <div class="form-group">
                        <label for="donationTarget">Annual Donation Target (₹):</label>
                        <!-- MODIFICATION: Removed step="1000" -->
                        <input type="number" id="donationTarget" name="target" min="0" required>
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Save Target</button>
                </form>
            </section>

        </main>
    </div>

    <!-- Donation Detail Modal -->
    <div id="donationDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-button donation-close-button">&times;</span>
            <h3 id="modalDonationTitle"><i class="fas fa-info-circle"></i> Donation Details</h3>
            <div id="modalDonationContent">
                <p><strong>Donor Name:</strong> <span id="detailDonorName"></span></p>
                <p><strong>Amount:</strong> ₹ <span id="detailAmount"></span></p>
                <!-- Removed Cause from modal -->
                <p><strong>Date:</strong> <span id="detailDate"></span></p>
                <p><strong>Payment Method:</strong> <span id="detailPaymentMethod"></span></p>
                <p><strong>Transaction ID:</strong> <span id="detailTransactionId"></span></p>
                <p><strong>Donor Email:</strong> <span id="detailDonorEmail"></span></p>
                <p><strong>Donor Phone:</strong> <span id="detailDonorPhone"></span></p>
            </div>
        </div>
    </div>

    <!-- News/Publication Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close-button delete-close-button">&times;</span>
            <h3><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h3>
            <p>Are you sure you want to delete this <strong id="deleteItemType"></strong>?</p>
            <p><strong>Title:</strong> <span id="deleteItemTitle"></span></p>
            <p><strong>Published Date:</strong> <span id="deleteItemDate"></span></p>
            <div style="text-align: right; margin-top: 20px;">
                <button class="btn" id="cancelDeleteBtn" style="background-color: var(--accent-color); margin-right: 10px;">Cancel</button>
                <button class="btn delete-btn" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>

    <!-- NEW: Application Detail Modal -->
    <div id="applicationDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-button application-close-button">&times;</span>
            <h3 id="modalApplicationTitle"><i class="fas fa-info-circle"></i> Application Details</h3>
            <div id="modalApplicationContent">
                <p><strong>Notification Title:</strong> <span id="detailApplicationNotificationId"></span></p>
                <p><strong>Name:</strong> <span id="detailApplicationName"></span></p>
                <p><strong>Email:</strong> <span id="detailApplicationEmail"></span></p>
                <p><strong>Phone Number:</strong> <span id="detailApplicationPhone"></span></p>
                <p><strong>Location:</strong> <span id="detailApplicationLocation"></span></p>
                <p><strong>Studying:</strong> <span id="detailApplicationStudying"></span></p>
                <p><strong>Message:</strong> <span id="detailApplicationMessage"></span></p>
                <p><strong>Submitted At:</strong> <span id="detailApplicationSubmittedAt"></span></p>
            </div>
        </div>
    </div>

    <!-- NEW: Album Photos Modal -->
    <div id="albumPhotosModal" class="modal">
        <div class="modal-content">
            <span class="close-button album-photos-close-button">&times;</span>
            <h3 id="modalAlbumTitle"><i class="fas fa-images"></i> Photos in Album: <span id="currentAlbumName"></span></h3>
            <div id="albumPhotosContainer" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; max-height: 60vh; overflow-y: auto;">
                <!-- Album photos will be loaded dynamically here -->
            </div>
        </div>
    </div>

    <script>
        // --- Global Variables (Moved to top for wider scope) ---
        let staticDonations = {}; // This object will now be populated by the fetch request
        let currentDonationTarget = parseFloat(localStorage.getItem('donationTarget')) || 1000000; // Default to 1,000,000 if not set
        let itemToDelete = null; // To store the item's data for deletion
        let staticApplications = {}; // NEW: Global variable to store application data
        let staticAlbums = {}; // NEW: Global variable to store album data

        // --- Function to set max date for all date inputs to today ---
        function setMaxDateToToday() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const dd = String(today.getDate()).padStart(2, '0');
            const todayString = `${yyyy}-${mm}-${dd}`;

            document.querySelectorAll('input[type="date"]').forEach(input => {
                input.setAttribute('max', todayString);
            });
        }

        // Function to update campaign stats
        function updateCampaignStats() {
            const totalRaised = Object.values(staticDonations).reduce((sum, donation) => {
                // Only sum donations for the "Educate a Child" campaign (or all if no specific campaign)
                // For simplicity, assuming all donations contribute to the main campaign.
                // If you have specific campaign tracking, you'd filter here.
                return sum + parseFloat(donation.amount);
            }, 0);

            const achievedPercentage = currentDonationTarget > 0 ? (totalRaised / currentDonationTarget) * 100 : 0;

            document.getElementById('campaignTarget').textContent = currentDonationTarget.toLocaleString();
            document.getElementById('campaignRaised').textContent = totalRaised.toLocaleString();
            const progressBar = document.getElementById('campaignProgressBar');
            progressBar.style.width = `${Math.min(achievedPercentage, 100)}%`;
            progressBar.textContent = `${Math.round(achievedPercentage)}%`;
            document.getElementById('campaignAchievedPercentage').textContent = Math.round(achievedPercentage);
        }

        // Function to render table rows based on current staticDonations data
        function renderDonationTable() {
            const tableBody = document.querySelector('#donations .data-table tbody'); // Specific selector
            tableBody.innerHTML = ''; // Clear existing rows

            Object.values(staticDonations).forEach(donation => {
                const row = tableBody.insertRow();
                row.setAttribute('data-id', donation.id); // Add data-id to row for easy access
                row.innerHTML = `
                    <td>${donation.donorName}</td>
                    <td>${donation.amount}</td>
                    <td>${donation.date}</td>
                    <td>${donation.transactionId || 'N/A'}</td>
                    <td>${donation.donorPhone || 'N/A'}</td>
                    <td>
                        <button class="action-btn view-btn" data-id="${donation.id}" data-type="donation"><i class="fas fa-eye"></i> View</button>
                        <button class="action-btn delete-btn" data-id="${donation.id}" data-type="donation"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                `;
            });
            attachDonationButtonListeners(); // Re-attach listeners after rendering
        }

        // Ensure attachDonationButtonListeners correctly targets and attaches events
        function attachDonationButtonListeners() {
            // Re-select view and delete buttons as they might be re-rendered
            const currentViewButtons = document.querySelectorAll('#donations .action-btn.view-btn');
            const currentDeleteButtons = document.querySelectorAll('#donations .action-btn.delete-btn');

            currentViewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const donationId = this.getAttribute('data-id');
                    const donation = staticDonations[donationId];

                    if (donation) {
                        document.getElementById('detailDonorName').textContent = donation.donorName;
                        document.getElementById('detailAmount').textContent = donation.amount;
                        document.getElementById('detailDate').textContent = donation.date;
                        document.getElementById('detailPaymentMethod').textContent = donation.paymentMethod || 'N/A';
                        document.getElementById('detailTransactionId').textContent = donation.transactionId || 'N/A';
                        document.getElementById('detailDonorEmail').textContent = donation.donorEmail || 'N/A';
                        document.getElementById('detailDonorPhone').textContent = donation.donorPhone || 'N/A';
                        donationDetailModal.style.display = 'flex';
                    }
                });
            });

            currentDeleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type'); // Get the type (should be 'donation')
                    const donation = staticDonations[id]; // Get the specific donation object

                    // Populate the delete confirmation modal
                    document.getElementById('deleteItemType').textContent = type.replace('_', ' ');
                    document.getElementById('deleteItemTitle').textContent = donation ? donation.donorName : 'N/A'; // Display donor name
                    document.getElementById('deleteItemDate').textContent = donation ? donation.date : 'N/A'; // Display donation date
                    
                    itemToDelete = { id, type }; // Store the item's data for deletion
                    deleteConfirmModal.style.display = 'flex';
                });
            });
        }

        // New function to render only filtered donations
        function renderFilteredDonationTable(donationsToRender) {
            const tableBody = document.querySelector('#donations .data-table tbody');
            tableBody.innerHTML = ''; // Clear existing rows

            donationsToRender.forEach(donation => {
                const row = tableBody.insertRow();
                row.setAttribute('data-id', donation.id);
                row.innerHTML = `
                    <td>${donation.donorName}</td>
                    <td>${donation.amount}</td>
                    <td>${donation.date}</td>
                    <td>${donation.transactionId || 'N/A'}</td>
                    <td>${donation.donorPhone || 'N/A'}</td>
                    <td>
                        <button class="action-btn view-btn" data-id="${donation.id}" data-type="donation"><i class="fas fa-eye"></i> View</button>
                        <button class="action-btn delete-btn" data-id="${donation.id}" data-type="donation"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                `;
            });
            attachDonationButtonListeners(); // Re-attach listeners after rendering
        }

        // --- Search, Filter, and Date Filter Logic (Donations) ---
        function applyDonationFilters() {
            const donationSearchInput = document.querySelector('#donations .filter-bar .search-input');
            const donationFilterDate = document.querySelector('#donations .filter-bar .filter-date');

            const searchTerm = donationSearchInput.value.toLowerCase();
            const selectedDate = donationFilterDate.value; // This will be in YYYY-MM-DD format

            const filteredDonations = Object.values(staticDonations).filter(donation => {
                const donorName = donation.donorName.toLowerCase();
                const date = donation.date; // Assuming this is also in YYYY-MM-DD format from backend

                const matchesSearch = donorName.includes(searchTerm);
                // For date matching, ensure both are in the same format.
                // If backend date includes time, you might need `date.startsWith(selectedDate)`
                const matchesDate = selectedDate === '' || date === selectedDate; 

                return matchesSearch && matchesDate;
            });
            renderFilteredDonationTable(filteredDonations);
        }

        // Function to update dashboard stats (Total Donors and Total Amount)
        function updateDashboardStats() {
            const uniqueDonors = new Set();
            let totalAmount = 0;

            Object.values(staticDonations).forEach(donation => {
                uniqueDonors.add(donation.donorName); // Assuming donorName is unique enough for counting donors
                totalAmount += parseFloat(donation.amount);
            });

            document.getElementById("totalDonors").textContent = uniqueDonors.size.toLocaleString();
            document.getElementById("totalAmount").textContent = "₹ " + totalAmount.toLocaleString();
        }

        // Function to load and display news
        function loadNews() {
            const newsListDiv = document.getElementById('newsList');
            newsListDiv.innerHTML = '<p>Loading news...</p>'; // Show loading message

            fetch('admin/get_news.php') // Assuming you have a backend script to get news
                .then(response => response.json())
                .then(newsItems => {
                    if (newsItems.length > 0) {
                        newsListDiv.innerHTML = ''; // Clear loading message
                        newsItems.forEach(news => {
                            const newsCard = document.createElement('div');
                            newsCard.classList.add('item-card');
                            if (!news.id) {
                                console.warn('News item missing ID:', news);
                                return;
                            }
                            newsCard.setAttribute('data-id', news.id);
                            newsCard.setAttribute('data-type', 'news');
                            newsCard.setAttribute('data-title', news.title);
                            newsCard.setAttribute('data-date', news.published_at);
                            newsCard.innerHTML = `
                                <span>${news.title} (${news.published_at})</span>
                                <button class="action-btn delete-btn" data-type="news" data-id="${news.id}"><i class="fas fa-trash"></i> Delete</button>
                            `;
                            newsListDiv.appendChild(newsCard);
                        });
                        attachDeleteListeners(); // Attach listeners after rendering
                    } else {
                        newsListDiv.innerHTML = '<p>No news articles found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching news:', error);
                    newsListDiv.innerHTML = '<p>Failed to load news. Please check the server.</p>';
                });
        }

        // Function to load and display publications
        function loadPublications() {
            const publicationListDiv = document.getElementById('publicationList');
            publicationListDiv.innerHTML = '<p>Loading publications...</p>'; // Show loading message

            fetch('admin/get_publications.php') // Assuming you have a backend script to get publications
                .then(response => response.json())
                .then(publications => {
                    if (publications.length > 0) {
                        publicationListDiv.innerHTML = ''; // Clear loading message
                        publications.forEach(pub => {
                            const pubCard = document.createElement('div');
                            pubCard.classList.add('item-card');
                            pubCard.setAttribute('data-id', pub.id);
                            pubCard.setAttribute('data-type', 'publication');
                            pubCard.setAttribute('data-title', pub.title);
                            pubCard.setAttribute('data-date', pub.published_at);
                            pubCard.innerHTML = `
                                <span>${pub.title} (${pub.published_at})</span>
                                <button class="action-btn delete-btn" data-type="publication" data-id="${pub.id}"><i class="fas fa-trash"></i> Delete</button>
                            `;
                            publicationListDiv.appendChild(pubCard);
                        });
                        attachDeleteListeners(); // Attach listeners after rendering
                    } else {
                        publicationListDiv.innerHTML = '<p>No publications found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching publications:', error);
                    publicationListDiv.innerHTML = '<p>Failed to load publications. Please check the server.</p>';
                });
        }

        // Function to load and display stories (What We Do)
        function loadStories() {
            const storiesListDiv = document.getElementById('storiesList');
            storiesListDiv.innerHTML = '<p>Loading programs...</p>';

            fetch('admin/get_stories.php') // You'll need to create this backend script
                .then(response => response.json())
                .then(storyItems => {
                    if (storyItems.length > 0) {
                        storiesListDiv.innerHTML = '';
                        storyItems.forEach(story => {
                            const storyCard = document.createElement('div');
                            storyCard.classList.add('item-card');
                            storyCard.setAttribute('data-id', story.id);
                            storyCard.setAttribute('data-type', 'story');
                            storyCard.setAttribute('data-title', story.title);
                            storyCard.innerHTML = `
                                <span>${story.title}</span>
                                <button class="action-btn delete-btn" data-type="story" data-id="${story.id}"><i class="fas fa-trash"></i> Delete</button>
                            `;
                            storiesListDiv.appendChild(storyCard);
                        });
                        attachDeleteListeners(); // Re-attach listeners after rendering
                    } else {
                        storiesListDiv.innerHTML = '<p>No programs found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching stories:', error);
                    storiesListDiv.innerHTML = '<p>Failed to load programs. Please check the server.</p>';
                });
        }

        // Function to load and display success stories
        function loadSuccessStories() {
            const successStoriesListDiv = document.getElementById('successStoriesList');
            successStoriesListDiv.innerHTML = '<p>Loading success stories...</p>';

            fetch('admin/get_success_stories.php') // You'll need to create this backend script
                .then(response => response.json())
                .then(successStoryItems => {
                    if (successStoryItems.length > 0) {
                        successStoriesListDiv.innerHTML = '';
                        successStoryItems.forEach(successStory => {
                            const successStoryCard = document.createElement('div');
                            successStoryCard.classList.add('item-card');
                            successStoryCard.setAttribute('data-id', successStory.id);
                            successStoryCard.setAttribute('data-type', 'success_story');
                            successStoryCard.setAttribute('data-title', successStory.title);
                            successStoryCard.innerHTML = `
                                <span>${successStory.title}</span>
                                <button class="action-btn delete-btn" data-type="success_story" data-id="${successStory.id}"><i class="fas fa-trash"></i> Delete</button>
                            `;
                            successStoriesListDiv.appendChild(successStoryCard);
                        });
                        attachDeleteListeners(); // Re-attach listeners after rendering
                    } else {
                        successStoriesListDiv.innerHTML = '<p>No success stories found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching success stories:', error);
                    successStoriesListDiv.innerHTML = '<p>Failed to load success stories. Please check the server.</p>';
                });
        }

        // NEW: Function to load and display applications data
        function loadApplicationsData() {
            const applicationsTableBody = document.getElementById('applicationsTableBody');
            applicationsTableBody.innerHTML = '<tr><td colspan="8">Loading applications...</td></tr>'; // Updated colspan

            fetch('admin/get_applications.php')
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data) && data.length > 0) {
                        applicationsTableBody.innerHTML = ""; // clear table
                        staticApplications = {}; // Clear and repopulate staticApplications

                        // Populate notification title dropdown with unique titles
                        const dropdown = document.getElementById('notificationTitleDropdown');
                        dropdown.innerHTML = '<option value="">All Notifications</option>'; // Reset dropdown
                        const uniqueTitles = new Set();

                        data.forEach(app => {
                            staticApplications[app.id] = app; // Store application data globally
                            if (app.notification_title) {
                                uniqueTitles.add(app.notification_title);
                            }
                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td>${app.notification_title}</td> <!-- ✅ Show title, not ID -->
                                <td>${app.name}</td>
                                <td>${app.phone}</td>
                                <td>${app.email}</td>
                                <td>${app.location}</td>
                                <td>${app.studying}</td>
                                <td>${app.submitted_at}</td>
                                <td>
                                    <button class="action-btn view-btn" data-id="${app.id}" data-type="application"><i class="fas fa-eye"></i> View</button>
                                    <button class="action-btn delete-btn" data-id="${app.id}" data-type="application"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            `;
                            applicationsTableBody.appendChild(row);
                        });

                        // Add unique titles to dropdown
                        uniqueTitles.forEach(title => {
                            const option = document.createElement('option');
                            option.value = title;
                            option.textContent = title;
                            dropdown.appendChild(option);
                        });

                        attachApplicationButtonListeners(); // Attach listeners after rendering
                    } else {
                        applicationsTableBody.innerHTML = `<tr><td colspan="8">No applications found.</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching applications:', error);
                    applicationsTableBody.innerHTML =
                        `<tr><td colspan="8">Error loading applications.</td>`; // Updated colspan
                });
        }

        // NEW: Function to render application table rows
        function renderApplicationTable(applicationsToRender) {
            const applicationsTableBody = document.getElementById('applicationsTableBody');
            applicationsTableBody.innerHTML = ''; // Clear existing rows

            if (applicationsToRender.length === 0) {
                applicationsTableBody.innerHTML = '<tr><td colspan="8">No applications found.</td></tr>'; // Updated colspan
                return;
            }

            applicationsToRender.forEach(app => {
                const row = applicationsTableBody.insertRow();
                row.setAttribute('data-id', app.id);
                row.innerHTML = `
                    <td>${app.notification_title || 'N/A'}</td>
                    <td>${app.name}</td>
                    <td>${app.phone || 'N/A'}</td>
                    <td>${app.email}</td>
                    <td>${app.location || 'N/A'}</td>
                    <td>${app.studying || 'N/A'}</td>
                    <td>${app.submitted_at || 'N/A'}</td>
                    <td>
                        <button class="action-btn view-btn" data-id="${app.id}" data-type="application"><i class="fas fa-eye"></i> View</button>
                        <button class="action-btn delete-btn" data-id="${app.id}" data-type="application"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                `;
            });
            attachApplicationButtonListeners(); // Attach listeners after rendering
        }

        // NEW: Function to attach listeners for application buttons
        function attachApplicationButtonListeners() {
            document.querySelectorAll('#applicationsSection .action-btn.view-btn').forEach(button => {
                button.addEventListener('click', function() { // Changed to addEventListener
                    const appId = this.getAttribute('data-id');
                    const application = staticApplications[appId];

                    if (application) {
                        // Removed ID from modal content
                        document.getElementById('detailApplicationNotificationId').textContent = application.notification_title || 'N/A'; // NEW FIELD
                        document.getElementById('detailApplicationName').textContent = application.name;
                        document.getElementById('detailApplicationEmail').textContent = application.email;
                        document.getElementById('detailApplicationPhone').textContent = application.phone || 'N/A';
                        document.getElementById('detailApplicationLocation').textContent = application.location || 'N/A';
                        document.getElementById('detailApplicationStudying').textContent = application.studying || 'N/A';
                        document.getElementById('detailApplicationMessage').textContent = application.message || 'N/A';
                        document.getElementById('detailApplicationSubmittedAt').textContent = application.submitted_at || 'N/A'; // NEW FIELD
                        document.getElementById('applicationDetailModal').style.display = 'flex';
                    }
                });
            });

            document.querySelectorAll('#applicationsSection .action-btn.delete-btn').forEach(button => {
                button.addEventListener('click', function() { // Changed to addEventListener
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type'); // Should be 'application'
                    const application = staticApplications[id];

                    document.getElementById('deleteItemType').textContent = type.replace('_', ' ');
                    document.getElementById('deleteItemTitle').textContent = application ? application.name : 'N/A';
                    document.getElementById('deleteItemDate').textContent = application ? application.submitted_at : 'N/A'; // Changed to submitted_at
                    
                    itemToDelete = { id, type };
                    deleteConfirmModal.style.display = 'flex';
                });
            });
        }

        // NEW: Search, Filter, and Date Filter Logic (Applications)
        function applyApplicationFilters() {
        const applicationFilterDate = document.getElementById('applicationFilterDate');
        const notificationTitleDropdown = document.getElementById('notificationTitleDropdown');

        const selectedDate = applicationFilterDate.value;
        const selectedNotificationTitle = notificationTitleDropdown.value.toLowerCase();

        const filteredApplications = Object.values(staticApplications).filter(app => {
            const submittedAt = app.submitted_at;
            const notificationTitle = app.notification_title ? app.notification_title.toLowerCase() : '';

            const matchesNotificationTitle = selectedNotificationTitle === '' || notificationTitle === selectedNotificationTitle;

            // Date matching: Check if selectedDate is empty or if submittedAt starts with selectedDate
            const matchesDate = selectedDate === '' || submittedAt.startsWith(selectedDate);

            return matchesNotificationTitle && matchesDate;
        });
        renderApplicationTable(filteredApplications);
        }

        // NEW: Function to load and display albums (MODIFIED from loadPhotos)
        function loadAlbums() {
            const albumListDiv = document.getElementById('albumList');
            albumListDiv.innerHTML = '<p>Loading albums...</p>';

            const selectAlbumDropdown = document.getElementById('selectAlbum');
            selectAlbumDropdown.innerHTML = '<option value="">-- Select an Album --</option>'; // Clear and reset

            fetch('admin/get_albums.php')
                .then(response => response.json())
                .then(albumItems => {
                    if (albumItems.length > 0) {
                        albumListDiv.innerHTML = ''; // Clear loading message
                        staticAlbums = {}; // Clear and repopulate staticAlbums

                        albumItems.forEach(album => {
                            if (!album.id) {
                                console.warn('Album item missing ID from backend:', album);
                                return;
                            }
                            staticAlbums[album.id] = album; // Store album data globally

                            // Render album card
                            const albumCard = document.createElement('div');
                            albumCard.classList.add('album-card');
                            albumCard.setAttribute('data-id', album.id);
                            albumCard.setAttribute('data-type', 'album');
                            albumCard.setAttribute('data-title', album.title);
                            albumCard.innerHTML = `
                                <img src="${album.cover_image}" alt="${album.title}">
                                <h4>${album.title}</h4>
                                <p>${album.description || 'No description'}</p>
                                <div class="album-actions">
                                    <button class="action-btn view-album-btn" data-id="${album.id}"><i class="fas fa-eye"></i> View Photos</button>
                                    <button class="action-btn delete-btn" data-type="album" data-id="${album.id}"><i class="fas fa-trash"></i> Delete Album</button>
                                    
                                </div>
                            `;
                            albumListDiv.appendChild(albumCard);

                            // Populate dropdown
                            const option = document.createElement('option');
                            option.value = album.id;
                            option.textContent = album.title;
                            selectAlbumDropdown.appendChild(option);
                        });
                        function attachViewAlbumListeners() {
    const viewButtons = document.querySelectorAll('.view-album-btn');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent any default action
            const albumId = this.getAttribute('data-id');
            viewPhotos(albumId); // Call the fetch function to load photos
        });
    });
}

                        attachDeleteListeners(); // Attach listeners for delete buttons
                        attachViewAlbumListeners(); // Attach listeners for view album buttons
                    } else {
                        albumListDiv.innerHTML = '<p>No albums found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching albums:', error);
                    albumListDiv.innerHTML = '<p>Failed to load albums. Please check the server.</p>';
                });
        }

        // NEW: Function to view photos within an album
        function viewAlbumPhotos(albumId) {
            const album = staticAlbums[albumId];
            if (!album) {
                console.error('Album not found:', albumId);
                return;
            }

            const albumPhotosModal = document.getElementById('albumPhotosModal');
            const currentAlbumName = document.getElementById('currentAlbumName');
            const albumPhotosContainer = document.getElementById('albumPhotosContainer');

            currentAlbumName.textContent = album.title;
            albumPhotosContainer.innerHTML = ''; // Clear previous photos

            if (album.photos && album.photos.length > 0) {
                album.photos.forEach(photoPath => {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.style.position = 'relative';
                    imgWrapper.style.width = '150px';
                    imgWrapper.style.height = '150px';
                    imgWrapper.style.overflow = 'hidden';
                    imgWrapper.style.borderRadius = '8px';
                    imgWrapper.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';

                    const img = document.createElement('img');
                    img.src = photoPath; // Path already includes 'admin/' from get_albums.php
                    img.alt = album.title;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.display = 'block';

                    // Optional: Add a delete button for individual photos within the modal
                    const deletePhotoBtn = document.createElement('button');
                    deletePhotoBtn.classList.add('action-btn', 'delete-btn');
                    deletePhotoBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    deletePhotoBtn.style.position = 'absolute';
                    deletePhotoBtn.style.top = '5px';
                    deletePhotoBtn.style.right = '5px';
                    deletePhotoBtn.style.padding = '5px';
                    deletePhotoBtn.style.fontSize = '0.7rem';
                    deletePhotoBtn.style.backgroundColor = 'rgba(220, 53, 69, 0.8)';
                    deletePhotoBtn.style.zIndex = '10';
                    deletePhotoBtn.title = 'Delete Photo';
                    // deletePhotoBtn.addEventListener('click', () => {
                    //     // You'll need a backend endpoint to delete individual photos by their path or ID
                    //     // For now, this is a placeholder. You might need to pass photoPath or a photo ID.
                    //     if (confirm('Are you sure you want to delete this photo?')) {
                    //         // Assuming photoPath contains enough info to delete, or you need photo ID from backend
                    //         deleteItem('album_photo', photoPath); // 'album_photo' is a new type for deletion
                    //     }
                    // });

                    imgWrapper.appendChild(img);
                    // imgWrapper.appendChild(deletePhotoBtn);
                    albumPhotosContainer.appendChild(imgWrapper);
                });
            } else {
                albumPhotosContainer.innerHTML = '<p>No photos in this album yet.</p>';
            }

            albumPhotosModal.style.display = 'flex';
        }

        // NEW: Attach listeners for "View Photos" buttons on album cards
        function attachViewAlbumListeners() {
            document.querySelectorAll('.view-album-btn').forEach(button => {
                button.removeEventListener('click', handleViewAlbumClick); // Prevent duplicate listeners
                button.addEventListener('click', handleViewAlbumClick);
            });
        }

        function handleViewAlbumClick() {
            const albumId = this.getAttribute('data-id');
            viewAlbumPhotos(albumId);
        }


        // Function to attach delete listeners to all delete buttons (existing, but ensure it covers new types)
        function attachDeleteListeners() {
            // Remove existing listeners to prevent duplicates
            document.querySelectorAll('.action-btn.delete-btn').forEach(button => {
                button.removeEventListener('click', handleDeleteButtonClick);
            });

            // Add new listeners
            document.querySelectorAll('.action-btn.delete-btn').forEach(button => {
                button.addEventListener('click', handleDeleteButtonClick);
            });
        }

        // Centralized handler for delete button clicks
        function handleDeleteButtonClick() {
            const id = this.getAttribute('data-id');
            if (!id) {
                console.error('Error: Missing ID on delete button for element:', this);
                return;
            }
            const type = this.getAttribute('data-type');
            
            // If the type is 'album', directly call deleteAlbum and bypass the modal
            if (type === 'album') {
                deleteAlbum(id);
                return; // Stop execution here
            }

            let title = 'N/A';
            let date = 'N/A';

            // Determine title and date based on type for the modal
            if (type === 'news') {
                const itemCard = this.closest('.item-card');
                title = itemCard ? itemCard.getAttribute('data-title') : '';
                date = itemCard ? itemCard.getAttribute('data-date') : '';
            } else if (type === 'publication') {
                const itemCard = this.closest('.item-card');
                title = itemCard ? itemCard.getAttribute('data-title') : '';
                date = itemCard ? itemCard.getAttribute('data-date') : '';
            } else if (type === 'story') {
                const itemCard = this.closest('.item-card');
                title = itemCard ? itemCard.getAttribute('data-title') : '';
            } else if (type === 'success_story') {
                const itemCard = this.closest('.item-card');
                title = itemCard ? itemCard.getAttribute('data-title') : '';
            } else if (type === 'donation') {
                const donation = staticDonations[id];
                title = donation ? donation.donorName : 'N/A';
                date = donation ? donation.date : 'N/A';
            } else if (type === 'application') { // NEW: Handle application type
                const application = staticApplications[id];
                title = application ? application.name : 'N/A';
                date = application ? application.submitted_at : 'N/A'; // Changed to submitted_at
            } else if (type === 'album_photo') { // NEW: Handle individual album photo deletion
                // For individual photos, 'id' here is actually the photoPath
                title = id.split('/').pop(); // Get filename from path
                date = 'N/A'; // Or try to get date if available
            }

            document.getElementById('deleteItemType').textContent = type.replace('_', ' '); // For display
            document.getElementById('deleteItemTitle').textContent = title || 'N/A'; // Handle if title is not present
            document.getElementById('deleteItemDate').textContent = date || 'N/A'; // Handle if date is not present
            
            itemToDelete = { id, type }; // Store for confirmation
            deleteConfirmModal.style.display = 'flex';
        }

        // Generic function to handle deletion
        function deleteItem(type, id) {
            let endpoint = '';
            let successMessage = '';
            let errorMessage = '';
            let reloadFunction = null; // Function to call after successful deletion

            switch (type) {
                case 'donation':
                    endpoint = 'admin/delete_donation.php'; // You'll need this backend script
                    successMessage = 'Donation deleted successfully!';
                    errorMessage = 'Failed to delete donation.';
                    reloadFunction = () => {
                        // Reload donations data and re-render table
                        fetch("admin/get_donations.php")
                            .then(res => res.json())
                            .then(data => {
                                staticDonations = {};
                                data.forEach(d => {
                                    staticDonations[d.id] = {
                                        id: d.id,
                                        donorName: d.name,
                                        amount: d.amount,
                                        date: d.created_at.split(' ')[0],
                                        paymentMethod: d.type,
                                        transactionId: d.transaction_id,
                                        donorEmail: d.email,
                                        donorPhone: d.phone
                                    };
                                });
                                applyDonationFilters();
                                updateCampaignStats();
                                updateDashboardStats();
                            })
                            .catch(error => console.error('Error reloading donations:', error));
                    };
                    break;
                case 'news':
                    endpoint = 'admin/delete_news.php'; // You'll need this backend script
                    successMessage = 'News article deleted successfully!';
                    errorMessage = 'Failed to delete news article.';
                    reloadFunction = loadNews;
                    break;
                case 'publication':
                    endpoint = 'admin/delete_publication.php'; // You'll need this backend script
                    successMessage = 'Notification deleted successfully!';
                    errorMessage = 'Failed to delete notification.';
                    reloadFunction = loadPublications;
                    break;
                case 'story': // What We Do
                    endpoint = 'admin/delete_story.php'; // You'll need this backend script
                    successMessage = 'Program deleted successfully!';
                    errorMessage = 'Failed to delete program.';
                    reloadFunction = loadStories;
                    break;
                case 'success_story':
                    endpoint = 'admin/delete_success_story.php'; // You'll need this backend script
                    successMessage = 'Success story deleted successfully!';
                    errorMessage = 'Failed to delete success story.';
                    reloadFunction = loadSuccessStories;
                    break;
                case 'application':
                    endpoint = 'admin/delete_application.php'; // You'll need this backend script
                    successMessage = 'Application deleted successfully!';
                    errorMessage = 'Failed to delete application.';
                    reloadFunction = loadApplicationsData;
                    break;
                case 'album':
                    // This case is now handled directly by deleteAlbum function
                    // This 'deleteItem' function will not be called for 'album' type anymore
                    console.warn("deleteItem called for album type, which should be handled by deleteAlbum directly.");
                    return; 
                case 'album_photo':
                    // This case is more complex as 'id' is a path.
                    // You'd need a backend endpoint that accepts a photo path or a photo ID
                    // and removes that specific photo from the album and file system.
                    // For now, let's assume 'id' is the photo path.
                    endpoint = 'admin/delete_album_photo.php'; // You'll need this backend script
                    successMessage = 'Photo deleted successfully!';
                    errorMessage = 'Failed to delete photo.';
                    // After deleting a photo, you might want to reload the specific album's photos
                    // or the entire album list if photo counts are displayed.
                    // For simplicity, let's reload albums for now.
                    reloadFunction = loadAlbums;
                    break;
                default:
                    alert('Unknown item type for deletion.');
                    return;
            }

            // For album_photo, the 'id' might be a path, so send it as 'photo_path'
            const bodyData = { id: id }; // Changed from photo_id to id for generic use

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Send as JSON for consistency
                },
                body: JSON.stringify(bodyData)
            })
            .then(res => {
                if (!res.ok) {
                    // If response is not OK, read as text to get the raw error message
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.json(); // Expect JSON response from backend
            })
            .then(data => {
                if (data.success) {
                    alert(successMessage);
                    if (reloadFunction) {
                        reloadFunction(); // Reload the relevant list
                    }
                } else {
                    alert(errorMessage + ' ' + (data.message || ''));
                    console.error('Server error:', data.message);
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                // MODIFICATION: Added a more informative alert for the user
                alert('An unexpected network or server error occurred during deletion. Please check the console for details and ensure the server script is running correctly.');
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Call the function when the DOM is loaded
            setMaxDateToToday();

            // --- Login Page Logic (Frontend Only) ---
            const loginForm = document.getElementById('loginForm');
            const loginMessage = document.getElementById('loginMessage');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const username = document.getElementById('username').value;
                    const password = document.getElementById('password').value;

                    // Simple frontend validation (replace with actual backend authentication)
                    if (username === 'admin' && password === 'password123') {
                        loginMessage.textContent = 'Login successful! Redirecting...';
                        loginMessage.style.color = 'green';
                        // In a real app, you'd get a token from the server and store it
                        setTimeout(() => {
                            window.location.href = 'admin_dashboard.html'; // Redirect to this page itself
                        }, 1000);
                    } else {
                        loginMessage.textContent = 'Invalid username or password.';
                        loginMessage.style.color = 'red';
                    }
                });
            }

            // --- Dashboard Navigation Logic ---
            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            const adminSections = document.querySelectorAll('.admin-section');
            const logoutBtn = document.getElementById('logoutBtn');

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all links and sections
                    sidebarLinks.forEach(item => item.classList.remove('active'));
                    adminSections.forEach(section => {
                        section.classList.remove('active');
                    });

                    // Add active class to clicked link
                    this.classList.add('active');

                    // Show the corresponding section
                    const targetSectionId = this.getAttribute('data-section');
                    if (targetSectionId) {
                        const targetSection = document.getElementById(targetSectionId);
                        targetSection.classList.add('active');
                        
                        if (targetSectionId === 'applicationsSection') {
                            loadApplicationsData();
                        } else if (targetSectionId === 'photoGallerySection') {
                            loadAlbums(); // Load albums when the photo gallery section is activated
                        }
                    }
                });
            });

            // --- Logout Logic (Frontend Only) ---
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to logout?')) {
                        // In a real app, you'd clear authentication tokens/sessions
                        window.location.href = 'admin_login.html'; // Redirect to login page
                    }
                });
            }

            // --- Donation Detail Modal Logic ---
            const donationDetailModal = document.getElementById('donationDetailModal');
            const donationCloseButton = donationDetailModal ? donationDetailModal.querySelector('.donation-close-button') : null;

            if (donationCloseButton) {
                donationCloseButton.addEventListener('click', function() {
                    donationDetailModal.style.display = 'none';
                });
            }

            // Fix for cross button on Delete Confirmation Modal
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const deleteCloseButton = deleteConfirmModal ? deleteConfirmModal.querySelector('.delete-close-button') : null;
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            if (deleteCloseButton) {
                deleteCloseButton.addEventListener('click', function() {
                    deleteConfirmModal.style.display = 'none';
                    itemToDelete = null; // Clear itemToDelete on close
                });
            }

            // Fix for cross button on Application Detail Modal
            const applicationDetailModal = document.getElementById('applicationDetailModal');
            const applicationCloseButton = applicationDetailModal ? applicationDetailModal.querySelector('.application-close-button') : null;

            if (applicationCloseButton) {
                applicationCloseButton.addEventListener('click', function() {
                    applicationDetailModal.style.display = 'none';
                });
            }

            // NEW: Album Photos Modal Close Logic
            const albumPhotosModal = document.getElementById('albumPhotosModal');
            const albumPhotosCloseButton = albumPhotosModal ? albumPhotosModal.querySelector('.album-photos-close-button') : null;

            if (albumPhotosCloseButton) {
                albumPhotosCloseButton.addEventListener('click', function() {
                    albumPhotosModal.style.display = 'none';
                });
            }


            window.addEventListener('click', function(event) {
                if (event.target == donationDetailModal) {
                    donationDetailModal.style.display = 'none';
                }
                if (event.target == applicationDetailModal) {
                    applicationDetailModal.style.display = 'none';
                }
                if (event.target == deleteConfirmModal) {
                    deleteConfirmModal.style.display = 'none';
                }
                if (event.target == albumPhotosModal) { // NEW: Close album photos modal
                    albumPhotosModal.style.display = 'none';
                }
            });

            // Event listeners for donation filters
            const donationSearchInput = document.querySelector('#donations .filter-bar .search-input');
            const donationFilterDate = document.querySelector('#donations .filter-bar .filter-date');
            donationSearchInput.addEventListener('keyup', applyDonationFilters);
            donationFilterDate.addEventListener('change', applyDonationFilters);

            // Load donations from backend into staticDonations
            fetch("admin/get_donations.php")
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    staticDonations = {}; // Clear the object
                    data.forEach(d => {
                        staticDonations[d.id] = {
                            id: d.id,
                            donorName: d.name,
                            amount: d.amount,
                            date: d.created_at.split(' ')[0], // Ensure date is YYYY-MM-DD
                            paymentMethod: d.type,
                            transactionId: d.transaction_id,
                            donorEmail: d.email,
                            donorPhone: d.phone
                        };
                    });
                    applyDonationFilters(); // Apply filters after data is loaded (will render all if no filters set)
                    updateCampaignStats(); // Update campaign stats after donations are loaded
                    updateDashboardStats(); // Call this function to update dashboard stats
                })
                .catch(error => {
                    console.error('Error fetching donations:', error);
                    alert('Failed to load donation data. Please check the server and get_donations.php.');
                });

            // --- Client-Side Export Data Logic (UPDATED) ---
            const triggerExportBtn = document.getElementById('triggerExportBtn'); // Changed ID for clarity
            if (triggerExportBtn) {
                triggerExportBtn.addEventListener('click', function() {
                    const startDate = document.getElementById('exportStartDate').value;
                    const endDate = document.getElementById('exportEndDate').value;
                    const format = document.getElementById('exportFormat').value;

                    if (format === 'csv') {
                        exportDonationsToCSV(startDate, endDate); // Updated function call
                    } else {
                        alert('Only CSV export is supported client-side without additional libraries.');
                    }
                });
            }

            function exportDonationsToCSV(startDate, endDate) {
                let filteredData = Object.values(staticDonations);

                // Filter by date range
                if (startDate) {
                    filteredData = filteredData.filter(d => d.date >= startDate);
                }
                if (endDate) {
                    filteredData = filteredData.filter(d => d.date <= endDate);
                }

                // Format and sanitize data for CSV
                const formatField = (value) => {
                    if (value === undefined || value === null) return '""';
                    const strVal = String(value);
                    // Ensure phone numbers are treated as text to prevent Excel issues
                    if (strVal.match(/^\d+$/) && strVal.length >= 7 && strVal.length <= 15) { // Basic phone number check
                        return `"${strVal}"`; // Wrap in quotes to preserve leading zeros and prevent scientific notation
                    }
                    // Dates should already be in YYYY-MM-DD from the data processing, just wrap in quotes
                    if (/^\d{4}-\d{2}-\d{2}$/.test(strVal)) {
                        return `"${strVal}"`;
                    }
                    // Default escape for other fields
                    return `"${strVal.replace(/"/g, '""')}"`;
                };

                // Define CSV headers
                const headers = [
                    "ID", "Donor Name", "Amount (₹)", "Date", "Transaction ID",
                    "Payment Method", "Donor Email", "Donor Phone"
                ];

                // Map data to CSV rows with proper formatting
                const rows = filteredData.map(donation => [
                    donation.id,
                    formatField(donation.donorName),
                    formatField(donation.amount),
                    formatField(donation.date),
                    formatField(donation.transactionId || 'N/A'),
                    formatField(donation.paymentMethod || 'N/A'),
                    formatField(donation.donorEmail || 'N/A'),
                    formatField(donation.donorPhone || 'N/A')
                ]);

                // Combine headers and rows
                const csvContent = [
                    headers.join(","),
                    ...rows.map(e => e.join(","))
                ].join("\n");

                // Create a Blob and download link
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                if (link.download !== undefined) { // Feature detection for download attribute
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', 'donations_export.csv');
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    alert('Your browser does not support downloading files directly. Please copy the data manually.');
                }
            }

            // --- Placeholder for Email Management Buttons ---
            const emailButtons = document.querySelectorAll('#emails .btn');
            emailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    alert(`Email action: "${this.textContent.trim()}" (Not implemented in this frontend mock-up)`);
                });
            });

            // --- Settings Section Logic ---
        document.getElementById("settingsForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("admin/upload_logo.php", {
                method: "POST",
                body: formData
            })
            .then(async res => {
                const text = await res.text();
                console.log("Raw response:", text);

                let data;
                try {
                    data = JSON.parse(text);
                } catch (err) {
                    console.error("Invalid JSON response from server:", text);
                    alert("❌ Server returned an invalid response. Check console for details.");
                    return; // Stop execution if JSON is invalid
                }

                if (data.success) {
                    alert("✅ Logo uploaded successfully.");
                    const logoPreview = document.getElementById("logoPreview");
                    if (logoPreview) {
                        // Assuming data.path is the correct relative path to the uploaded logo
                        // Add a timestamp to the URL to prevent caching issues
                        logoPreview.src = data.path + "?t=" + new Date().getTime();
                    }
                } else {
                    alert("❌ Upload failed: " + data.message);
                }
            })
            .catch(err => {
                console.error("Error uploading logo:", err);
                alert("❌ An unexpected error occurred during logo upload. Check console for details.");
            });
        });


            document.getElementById("targetSettingsForm").addEventListener("submit", function (e) {
                e.preventDefault();
                const donationTargetInput = document.getElementById("donationTarget");
                const newTarget = parseFloat(donationTargetInput.value);

                if (!isNaN(newTarget) && newTarget >= 0) {
                    currentDonationTarget = newTarget; // Update the global target variable
                    localStorage.setItem('donationTarget', newTarget); // Save to localStorage
                    alert(`Donation target set to ₹${currentDonationTarget.toLocaleString()}.`);
                    console.log("Donation target saved:", currentDonationTarget);
                    updateCampaignStats(); // Recalculate and update campaign stats
                } else {
                    alert("Please enter a valid positive number for the donation target.");
                }
            });

            // Initial call to update campaign stats in case donations are already loaded
            // and target is default or loaded from elsewhere.
            updateCampaignStats();

            // Set the initial value of the donation target input field
            document.getElementById("donationTarget").value = currentDonationTarget;

            // ... (rest of your existing code) ...
        });

        // The original fetch for dashboard stats is removed as it's now handled by updateDashboardStats()
        // which is called after donations data is loaded.
        /*
        fetch("admin/get_dashboard_stats.php")
            .then(res => res.json())
            .then(stats => {
                document.getElementById("totalDonors").textContent = stats.total_donors.toLocaleString();
                document.getElementById("totalAmount").textContent = "₹ " + parseFloat(stats.total_amount).toLocaleString();
                // Removed the line for activeCampaigns as the element is removed from HTML
                // document.getElementById("activeCampaigns").textContent = stats.active_campaigns;
                // document.getElementById("mostCause").textContent = stats.most_supported_cause; // Removed
            })
            .catch(error => {
                console.error("Failed to load dashboard stats:", error);
                // Optionally, display an error message on the dashboard
                document.getElementById("totalDonors").textContent = "Error";
                document.getElementById("totalAmount").textContent = "Error";
            });
        */

        // --- Add News Form Submission ---
        document.getElementById("addNewsForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("admin/add_news.php", {
            method: "POST",
            body: formData
        })
            .then(res => {
                if (!res.ok) {
                    // If response is not OK, read as text to get the raw error message
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.json(); // Try to parse as JSON if OK
            })
            .then(data => {
                if (data.success) {
                alert("News uploaded successfully!");
                this.reset();
                loadNews(); // Reload news list after successful upload
                } else {
                alert("Upload failed: " + data.message);
                console.error("Server error:", data.message);
                }
            })
            .catch(err => {
            console.error("Fetch error:", err);
            alert("An unexpected network or server error occurred. Check console for details.");
            });
        });

        // --- Add Publication Form Submission ---
        document.getElementById("addPublicationForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("admin/add_publication.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(text => {
            try {
            const data = JSON.parse(text);
            if (data.success) {
                alert(data.message);
                this.reset();
                loadPublications(); // Reload publications list after successful upload
            } else {
                alert("Upload failed: " + data.message);
            }
            } catch (err) {
            console.error("Not JSON:\n", text);
            alert("Unexpected server response.");
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            alert("Network error occurred.");
        });
        });

        // --- Add Story Form Submission (for What We Do) ---
        document.getElementById("addStoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("admin/add_story.php", { // You'll need to create this backend script
            method: "POST",
            body: formData
        })
            .then(res => {
                if (!res.ok) {
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                alert("Program added successfully!");
                this.reset();
                loadStories(); // Reload stories list (What We Do)
                } else {
                alert("Upload failed: " + data.message);
                console.error("Server error:", data.message);
                }
            })
            .catch(err => {
            console.error("Fetch error:", err);
            alert("An unexpected network or server error occurred. Check console for details.");
            });
        });


        // --- Add Success Story Form Submission ---
        document.getElementById("addSuccessStoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("admin/add_success_story.php", { // You'll need to create this backend script
            method: "POST",
            body: formData
        })
            .then(res => {
                if (!res.ok) {
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                alert("Success Story uploaded successfully!");
                this.reset();
                loadSuccessStories(); // Reload success stories list
                } else {
                alert("Upload failed: " + data.message);
                console.error("Server error:", data.message);
                }
            })
            .catch(err => {
            console.error("Fetch error:", err);
            alert("An unexpected network or server error occurred. Check console for details.");
            });
        });

        // NEW: Add Album Form Submission
        document.getElementById("addAlbumForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("admin/upload_album.php", {
                method: "POST",
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.text(); // Server returns plain text success message
            })
            .then(text => {
                // Check if the response indicates success
                if (text.includes("Album created successfully")) {
                    alert("Album created successfully!");
                    this.reset();
                    loadAlbums(); // Reload album list and dropdown
                } else {
                    alert("Album creation failed: " + text);
                    console.error("Server error:", text);
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("An unexpected network or server error occurred. Check console for details.");
            });
        });

        // NEW: Add Photos to Album Form Submission
        document.getElementById("addPhotosToAlbumForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("admin/upload_album_photos.php", {
                method: "POST",
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    return res.text().then(text => { throw new Error(text); });
                }
                return res.text(); // Server returns plain text success message
            })
            .then(text => {
                if (text.includes("Photos uploaded successfully")) {
                    alert("Photos uploaded successfully!");
                    this.reset();
                    loadAlbums(); // Reload albums to update photo counts/display
                } else {
                    alert("Photo upload failed: " + text);
                    console.error("Server error:", text);
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("An unexpected network or server error occurred. Check console for details.");
            });
        });


        // --- News and Publication Listing and Deletion Logic ---
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const deleteCloseButton = deleteConfirmModal ? deleteConfirmModal.querySelector('.delete-close-button') : null;
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        // itemToDelete is already global

        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', () => {
                deleteConfirmModal.style.display = 'none';
                itemToDelete = null;
            });
        }

        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', () => {
                if (itemToDelete) {
                    deleteItem(itemToDelete.type, itemToDelete.id);
                    deleteConfirmModal.style.display = 'none';
                    itemToDelete = null;
                }
            });
        }

        // Event listeners for application filters
        const applicationFilterDate = document.getElementById('applicationFilterDate');
        const notificationTitleDropdown = document.getElementById('notificationTitleDropdown');
        notificationTitleDropdown.addEventListener('change', applyApplicationFilters);
        applicationFilterDate.addEventListener('change', applyApplicationFilters);


        // Initial load of news and publications when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadNews(); // Load news when the page loads
            loadPublications(); // Load publications when the page loads
            loadStories(); // Load stories (What We Do) when the page loads
            loadSuccessStories(); // Load success stories when the page loads
            // loadAlbums(); // Don't load albums initially, only when section is active

            // Re-attach listeners for navigation to ensure news/publication lists are loaded
            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const targetSectionId = this.getAttribute('data-section');
                    if (targetSectionId === 'addNewsSection') {
                        loadNews();
                    } else if (targetSectionId === 'addPublicationSection') {
                        loadPublications();
                    } else if (targetSectionId === 'storiesSection') { // Ensure this reloads stories (What We Do)
                        loadStories();
                    } else if (targetSectionId === 'successStoriesSection') { // Ensure this reloads success stories
                        loadSuccessStories();
                    } else if (targetSectionId === 'applicationsSection') { // NEW: Load applications when clicked
                        loadApplicationsData();
                    } else if (targetSectionId === 'photoGallerySection') { // NEW: Load albums when clicked
                    
                    }
                });
            });
        });

       

        // Cancel button handler
        cancelDeleteBtn.addEventListener('click', () => {
            deleteConfirmModal.style.display = 'none';
            itemToDelete = null;
        });

        function editNews(newsId) {
            fetch(`edit_news.php?id=${newsId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Populate form with existing data
                        document.getElementById("newsTitle").value = data.title;
                        document.getElementById("newsContent").value = data.content;
                        // Assuming you have a hidden input for newsId in your form for editing
                        // document.getElementById("newsId").value = data.id; // hidden input
                    } else {
                        alert("Failed to load news for editing.");
                    }
                })
                .catch(err => {
                    console.error("Error loading news:", err);
                    alert("Error loading news data.");
                });
                
                
        }
function loadExistingPhotos() {
    fetch("admin/get_album_images.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("existingPhotosContainer").innerHTML = data;
        })
        .catch(error => console.error("Error loading photos:", error));
}

function deleteAlbum(albumId) {
    if (confirm("Are you sure you want to delete this album and all its photos?")) {
        let formData = new FormData();
        formData.append("album_id", albumId);

        fetch("admin/delete_album.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // ✅ "Album and photos deleted successfully"
                loadAlbums();          // Refresh albums dropdown/list
                loadExistingPhotos();  // Refresh existing photos section
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    }
}










        // This event listener is now the primary entry point for all delete buttons.
        // It will decide whether to show the modal or directly call a specific delete function.
        document.addEventListener("click", function(e) {
            const targetButton = e.target.closest(".delete-btn");
            if (targetButton) {
                const id = targetButton.getAttribute("data-id");
                const type = targetButton.getAttribute("data-type");

                // If it's an album delete button, directly call deleteAlbum
                if (type === "album") {
                    // The 'confirm' dialog is now the only confirmation for albums.
                    if (confirm("Are you sure you want to delete this album and all its photos? This action cannot be undone.")) {
                        deleteAlbum(id);
                    } else {
                        console.log("Album deletion cancelled by user.");
                    }
                } else {
                    // For all other types, proceed with the modal confirmation
                    handleDeleteButtonClick.call(targetButton); // Call the existing handler
                }
            }
        });

function attachDeleteAlbumListeners() {
    const deleteButtons = document.querySelectorAll('.delete-album-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const albumId = this.getAttribute('data-album-id');

            if (confirm("Are you sure you want to delete this album and all its photos?")) {
                deleteAlbum(albumId).then(success => {
                    if (success) {
                        // ✅ Remove album card from DOM
                        const albumElement = this.closest('.album-card');
                        if (albumElement) {
                            albumElement.remove();
                        }

                        // ✅ Also remove photos belonging to that album
                        document.querySelectorAll(`[data-album-id="${albumId}"]`).forEach(el => {
                            el.remove();
                        });
                    }
                });
            }
        });
    });
}


 function deleteAlbum(albumId) {
    if (confirm("Are you sure you want to delete this album and all its photos?")) {
        let formData = new FormData();
        formData.append("album_id", albumId);

        fetch("admin/delete_album.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);

                // ✅ Refresh albums dropdown/list
                loadAlbums();

                // ❌ Don't reload all photos (causes ghost images to show)
                // ✅ Instead remove only this album's photos
                const albumElement = document.querySelector(`[data-album-id="${albumId}"]`);
                if (albumElement) {
                    albumElement.remove();
                }
                document.querySelectorAll(`.photo-item[data-album-id="${albumId}"]`)
                    .forEach(photo => photo.remove());

            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    }
}


function viewPhotos(albumId) {
    fetch('admin/get_album_images.php?album_id=' + albumId)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('albumPhotosContainer');
            container.innerHTML = '';

            if (!data || data.length === 0) {
                container.innerHTML = '<p>No photos in this album.</p>';
                return;
            }

            data.forEach(photo => {
                const imgDiv = document.createElement('div');
                imgDiv.classList.add('photo-item');
                imgDiv.style.position = 'relative';
                imgDiv.innerHTML = `
                    <img src="${photo.image_path}" alt="Photo" />
                `;
                container.appendChild(imgDiv);

                // Click to open full-screen modal
                imgDiv.querySelector('img').addEventListener('click', function() {
                    const modal = document.getElementById('albumPhotosModal');
                    const modalImg = document.getElementById('modalImage');
                    if (modalImg) {
                        modalImg.src = this.src;
                        modal.style.display = 'flex';
                    }
                });
            });
        })
        .catch(err => console.error('Error loading photos:', err));
}
function deletePhoto(photoId) {
    if (!confirm("Are you sure you want to delete this photo?")) return;

    fetch('admin/delete_album_photo.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'photo_id=' + photoId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // remove photo from DOM
            const photoElement = document.getElementById('photo-' + photoId);
            if (photoElement) photoElement.remove();
        } else {
            alert("Failed to delete photo");
        }
    })
    .catch(err => console.error(err));
}

document.addEventListener('DOMContentLoaded', () => {

    // Delete photo
    document.querySelectorAll('.delete-photo-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const photoId = btn.getAttribute('data-id');
            if (!confirm("Are you sure you want to delete this photo?")) return;

            fetch('admin/delete_photo.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'photo_id=' + photoId
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const photoElement = document.getElementById('photo-' + photoId);
                    if (photoElement) photoElement.remove();
                } else {
                    alert('Failed to delete photo');
                }
            })
            .catch(err => console.error(err));
        });
    });

    // Delete album + its photos
    document.querySelectorAll('.delete-album-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const albumId = btn.getAttribute('data-id');
            if (!confirm("Are you sure you want to delete this album and all its photos?")) return;

            fetch('admin/delete_album_photo.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'album_id=' + albumId
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // remove album from DOM
                    const albumElement = document.getElementById('album-' + albumId);
                    if (albumElement) albumElement.remove();

                    // remove photos in that album from DOM
                    document.querySelectorAll(`.photo-item[data-album-id='${albumId}']`)
                        .forEach(photoEl => photoEl.remove());
                } else {
                    alert('Failed to delete album');
                }
            })
            .catch(err => console.error(err));
        });
    });

});






    </script>
</body>
</html>
