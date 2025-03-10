<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trainings - ADOHRE</title>
    <link rel="icon" href="assets/logo.png" type="image/jpg" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #2c3e50;
        --accent-color: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
    }

    .trainings-container {
        background: var(--accent-color);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .training-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .training-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.15);
    }

    .training-card img {
        height: 200px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }

    .training-badge {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 2rem;
        position: relative;
        padding-left: 1.5rem;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 70%;
        width: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .modal-content {
        border-radius: 15px;
        border: none;
    }

    .modal-header {
        border-bottom: 2px solid var(--primary-color);
    }

    .modal-title {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .btn-success {
        background-color: var(--primary-color);
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-primary {
        background-color: var(--secondary-color);
        border: none;
    }

    .training-details-list {
        list-style: none;
        padding-left: 0;
    }

    .training-details-list li {
        margin-bottom: 1rem;
        padding-left: 2rem;
        position: relative;
    }

    .training-details-list li i {
        position: absolute;
        left: 0;
        top: 2px;
        color: var(--primary-color);
    }

    .scrollable-section {
        max-height: 70vh;
        overflow-y: auto;
        padding-right: 1rem;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #218838;
    }

    #backToTopBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: var(--primary-color);
        color: white;
        cursor: pointer;
        padding: 15px 19px;
        border-radius: 50%;
        font-size: 1.2rem;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 52px;
        height: 52px;
    }

    #backToTopBtn:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
        <?php
      if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
      }
    ?>
    </header>

    <?php include('sidebar.php'); ?>

    <main class="container mt-4 mb-4">
        <div class="trainings-container">
            <h2 class="section-title">Available Trainings</h2>
            <div class="scrollable-section">
                <div class="row g-4" id="trainingsList"></div>
            </div>
        </div>
    </main>

    <!-- Modal for Viewing Training Details -->
    <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trainingModalLabel">Training Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="trainingModalImage" src="assets/default-training.jpg" alt="Training Image"
                                class="img-fluid rounded mb-3">
                        </div>
                        <div class="col-md-8">
                            <ul class="training-details-list">
                                <li>
                                    <i class="fas fa-align-left"></i>
                                    <strong>Description:</strong> <span id="trainingModalDescription"></span>
                                </li>
                                <li>
                                    <i class="fas fa-calendar-alt"></i>
                                    <strong>Schedule:</strong> <span id="trainingModalSchedule"></span>
                                </li>
                                <li>
                                    <i class="fas fa-users"></i>
                                    <strong>Capacity:</strong> <span id="trainingModalCapacity"></span>
                                </li>
                                <li>
                                    <i class="fas fa-laptop-house"></i>
                                    <strong>Modality:</strong> <span id="trainingModalModality"></span>
                                </li>
                                <li>
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Details:</strong> <span id="trainingModalModalityDetails"></span>
                                </li>
                            </ul>
                            <!-- New Assessment Section: Only shown for non-trainers -->
                            <?php if($_SESSION['role'] !== 'trainer'): ?>
                            <div id="assessmentSection" style="display: none; margin-top: 20px;">
                                <button id="takeAssessmentBtn" class="btn btn-primary">Take Assessment</button>
                                <p class="mt-2 text-danger">
                                    After submitting your answer in the form, click "Mark as Done" here to receive your
                                    certificate.
                                </p>
                                <button id="markDoneBtn" class="btn btn-warning">Mark as Done</button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Assessment Form (pops up when "Take Assessment" is clicked) -->
    <div class="modal fade" id="assessmentModal" tabindex="-1" aria-labelledby="assessmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assessmentModalLabel">Assessment Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="assessmentIframe" src="" width="100%" height="600" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <button id="backToTopBtn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const userId = "<?php echo $_SESSION['user_id']; ?>";
        const role = "<?php echo $_SESSION['role']; ?>"; // e.g., 'trainer' or 'user'
        let trainingsData = [];
        const trainingsList = document.getElementById('trainingsList');

        // Event delegation for training card buttons
        trainingsList.addEventListener('click', function(e) {
            const btn = e.target.closest('button');
            if (!btn) return;
            const trainingId = btn.dataset.trainingId;
            const training = trainingsData.find(t => t.training_id == trainingId);
            if (btn.classList.contains('join-training-btn')) {
                joinTraining(trainingId, btn);
            } else if (btn.classList.contains('view-training-btn')) {
                showTrainingModal(training);
            }
        });

        // Fetch trainings with absolute URL path
        fetch('/capstone-php/backend/routes/content_manager.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    trainingsData = data.trainings;
                    renderTrainings(data.trainings);
                } else {
                    showError('Failed to load trainings');
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showError('Failed to load trainings');
            });

        function renderTrainings(trainings) {
            const html = trainings.map(training => `
          <div class="col-12">
            <div class="training-card card">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="${training.image || 'assets/default-training.jpg'}" 
                       class="img-fluid training-image" 
                       alt="${training.title}">
                </div>
                <div class="col-md-8 p-3">
                  <div class="training-badge">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    ${training.modality || 'In-person'}
                  </div>
                  <h3 class="h5 fw-bold mb-2">${training.title}</h3>
                  <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-calendar-day text-primary me-2"></i>
                      <span>${new Date(training.schedule).toLocaleString()}</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <i class="fas fa-user-friends text-primary me-2"></i>
                      <span>${training.capacity} slots available</span>
                    </div>
                  </div>
                  <div class="mt-3">
                    ${training.joined == 1 
                      ? `<button class="btn btn-primary view-training-btn" data-training-id="${training.training_id}">
                           <i class="fas fa-eye me-2"></i>View Training
                         </button>`
                      : `<button class="btn btn-success join-training-btn" data-training-id="${training.training_id}">
                           <i class="fas fa-user-plus me-2"></i>Join Training
                         </button>`}
                  </div>
                </div>
              </div>
            </div>
          </div>
        `).join('');
            trainingsList.innerHTML = html ||
                '<p class="text-center text-muted">No trainings available currently</p>';
        }

        async function joinTraining(trainingId, button) {
            try {
                const response = await fetch(
                    '/capstone-php/backend/routes/training_registration.php?action=join_training', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            training_id: trainingId
                        })
                    });
                const data = await response.json();
                if (data.status) {
                    const trainingIndex = trainingsData.findIndex(t => t.training_id == trainingId);
                    trainingsData[trainingIndex].joined = 1;
                    renderTrainings(trainingsData);
                    alert('Successfully joined the training!');
                } else {
                    alert(data.message || 'Failed to join training');
                }
            } catch (err) {
                console.error('Join training error:', err);
                alert('Error joining training');
            }
        }

        function showTrainingModal(training) {
            if (!training) return;
            // Populate modal details
            document.getElementById('trainingModalLabel').textContent = training.title;
            document.getElementById('trainingModalImage').src = training.image || 'assets/default-training.jpg';
            document.getElementById('trainingModalDescription').textContent = training.description;
            document.getElementById('trainingModalSchedule').textContent = new Date(training.schedule)
                .toLocaleString();
            document.getElementById('trainingModalCapacity').textContent = training.capacity;
            document.getElementById('trainingModalModality').textContent = training.modality || 'Not provided';
            document.getElementById('trainingModalModalityDetails').textContent = training.modality_details ||
                'Not provided';

            // Store the current training id in a global variable
            window.currentTrainingId = training.training_id;

            // Show modal
            let modal = new bootstrap.Modal(document.getElementById('trainingModal'));
            modal.show();

            // For participants, fetch the assessment form link
            if (role !== 'trainer') {
                fetch(
                        `/capstone-php/backend/routes/assessment_manager.php?action=get_assessment_form&training_id=${training.training_id}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        const assessmentSection = document.getElementById('assessmentSection');
                        if (data.status && data.form_link) {
                            window.currentAssessmentForm = data.form_link;
                            assessmentSection.style.display = 'block';
                        } else {
                            assessmentSection.style.display = 'none';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('assessmentSection').style.display = 'none';
                    });
            } else {
                document.getElementById('assessmentSection').style.display = 'none';
            }
        }

        // "Take Assessment" button event listener: opens the assessment modal with embedded form.
        document.getElementById('takeAssessmentBtn').addEventListener('click', function() {
            if (window.currentAssessmentForm) {
                let formLink = window.currentAssessmentForm;
                if (formLink.indexOf('docs.google.com/forms') !== -1 && formLink.indexOf('hl=') === -
                    1) {
                    formLink += (formLink.indexOf('?') === -1) ? '?hl=en' : '&hl=en';
                }
                document.getElementById('assessmentIframe').src = formLink;
                let assessmentModal = new bootstrap.Modal(document.getElementById('assessmentModal'));
                assessmentModal.show();
            } else {
                alert("No assessment form link available for this training.");
            }
        });

        // "Mark as Done" button event listener: sends request to mark assessment as completed.
        document.getElementById('markDoneBtn').addEventListener('click', function() {
            const trainingId = window.currentTrainingId;
            if (!trainingId) {
                alert("Training not selected.");
                return;
            }
            fetch('/capstone-php/backend/routes/assessment_manager.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'mark_assessment_done',
                        user_id: userId,
                        training_id: trainingId
                    })
                })
                .then(resp => resp.json())
                .then(result => {
                    // If the response message contains "already marked", show that message;
                    // otherwise show the normal message.
                    if (result.status) {
                        if (result.message.toLowerCase().includes("already marked")) {
                            alert(result.message);
                        } else {
                            alert("Assessment marked as completed.");
                        }
                    } else {
                        alert("Error: " + result.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Failed to mark assessment as completed.");
                });
        });

    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>