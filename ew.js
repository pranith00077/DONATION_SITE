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
                        data.forEach(app => {
                            staticApplications[app.id] = app; // Store application data globally
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
            const applicationSearchInput = document.getElementById('applicationSearchInput');
            const applicationFilterDate = document.getElementById('applicationFilterDate');

            const searchTerm = applicationSearchInput.value.toLowerCase();
            const selectedDate = applicationFilterDate.value;

            const filteredApplications = Object.values(staticApplications).filter(app => {
                const name = app.name ? app.name.toLowerCase() : '';
                const email = app.email ? app.email.toLowerCase() : '';
                const phone = app.phone ? app.phone.toLowerCase() : '';
                const location = app.location ? app.location.toLowerCase() : '';
                const studying = app.studying ? app.studying.toLowerCase() : '';
                const message = app.message ? app.message.toLowerCase() : '';
                const submittedAt = app.submitted_at;
                const notificationTitle = app.notification_title ? app.notification_title.toLowerCase() : '';

                const matchesSearch = name.includes(searchTerm) ||
                                      email.includes(searchTerm) ||
                                      phone.includes(searchTerm) ||
                                      location.includes(searchTerm) ||
                                      studying.includes(searchTerm) ||
                                      message.includes(searchTerm) ||
                                      notificationTitle.includes(searchTerm);

                // Date matching: Check if selectedDate is empty or if submittedAt starts with selectedDate
                const matchesDate = selectedDate === '' || submittedAt.startsWith(selectedDate);

                return matchesSearch && matchesDate;
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
                    deletePhotoBtn.addEventListener('click', () => {
                        // You'll need a backend endpoint to delete individual photos by their path or ID
                        // For now, this is a placeholder. You might need to pass photoPath or a photo ID.
                        if (confirm('Are you sure you want to delete this photo?')) {
                            // Assuming photoPath contains enough info to delete, or you need photo ID from backend
                            deleteItem('album_photo', photoPath); // 'album_photo' is a new type for deletion
                        }
                    });

                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(deletePhotoBtn);
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
                alert('Error: Missing ID for deletion. Please refresh and try again.');
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
        const applicationSearchInput = document.getElementById('applicationSearchInput');
        const applicationFilterDate = document.getElementById('applicationFilterDate');
        applicationSearchInput.addEventListener('keyup', applyApplicationFilters);
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
                    <button class="delete-photo-btn" data-id="${photo.id}">Delete</button>
                `;
                container.appendChild(imgDiv);

                // Click to open full-screen modal
                imgDiv.querySelector('img').addEventListener('click', function() {
                    const modal = document.getElementById('photoModal');
                    const modalImg = document.getElementById('modalImage');
                    modalImg.src = this.src;
                    modal.style.display = 'flex';
                });

                // Click to delete photo
                imgDiv.querySelector('.delete-photo-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const photoId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this photo?')) {
                        deletePhoto(photoId, albumId);
                    }
                });
            });
        })
        .catch(err => console.error('Error loading photos:', err));
}




