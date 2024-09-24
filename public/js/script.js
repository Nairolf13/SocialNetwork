document.addEventListener('DOMContentLoaded', function () {
    // Connexion et Inscription
    const btnConnexion = document.getElementById('btn-connexion');
    const formulaireInscription = document.getElementById('formulaire_inscription');
    const formulaireConnexion = document.getElementById('formulaire_connexion');

    if (btnConnexion && formulaireInscription) {
        btnConnexion.addEventListener('click', function () {
            formulaireInscription.style.display = 'none';
            formulaireConnexion.style.display = 'block';
        });
    }

    // Vérification des mots de passe
    const form = document.querySelector('#formulaire_inscription form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    function checkPasswordMatch() {
        if (password.value !== confirmPassword.value) {
            password.classList.add('password-mismatch');
            confirmPassword.classList.add('password-mismatch');
        } else {
            password.classList.remove('password-mismatch');
            confirmPassword.classList.remove('password-mismatch');
        }
    }

    if (password && confirmPassword) {
        password.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    if (form) {
        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                showErrorModal('Les mots de passe ne correspondent pas.');
            }
        });
    }

    // Gestion des projets (ajout, modification, suppression)
    const btnAddProject = document.getElementById('btn-add-project');
    const addProjectForm = document.getElementById('add-project-form');

    if (btnAddProject && addProjectForm) {
        btnAddProject.addEventListener('click', () => {
            addProjectForm.classList.toggle('hidden');
        });
    }

    const projectTitles = document.querySelectorAll(".project-title");
    const projectDetailsDiv = document.getElementById("project-details");
    if (projectDetailsDiv) {
        projectDetailsDiv.classList.add('hidden');
    }

    projectTitles.forEach(title => {
        title.addEventListener("click", function () {
            const projectId = this.getAttribute("data-project-id");
            const projectTitle = this.getAttribute("data-project-title");
            const projectDescription = this.getAttribute("data-project-description");

            const currentlyDisplayedProjectId = projectDetailsDiv.getAttribute('data-project-id');

            if (projectDetailsDiv.classList.contains("hidden") || currentlyDisplayedProjectId !== projectId) {
                projectDetailsDiv.innerHTML = `
                    <h3>${projectTitle}</h3>
                    <p>${projectDescription}</p>
                    <img src="get_image.php?project_id=${projectId}" alt="${projectTitle}" style="max-width: 100%;">
                `;
                projectDetailsDiv.setAttribute('data-project-id', projectId);
                projectDetailsDiv.classList.remove("hidden");
            } else {
                projectDetailsDiv.classList.add("hidden");
                projectDetailsDiv.removeAttribute('data-project-id');
            }
        });
    });

    // Modification de projet
    const btnProfile = document.getElementById('btn-profile');
    const profileModal = document.getElementById('profile-modal');
    const closeProfileModal = document.getElementById('close-profile-modal');

    if (btnProfile && profileModal && closeProfileModal) {
        btnProfile.addEventListener('click', () => {
            profileModal.classList.toggle('hidden');
        });

        closeProfileModal.addEventListener('click', () => {
            profileModal.classList.add('hidden');
        });
    }

    const btnUpdateProject = document.querySelectorAll('.btn-update-project');
    const updateProjectForm = document.getElementById('update-project-form');
    const closeUpdateProjectForm = document.getElementById('close-update-project-form');

    btnUpdateProject.forEach(button => {
        button.addEventListener('click', (event) => {
            const projectLi = event.target.closest('.project-title');
            const projectId = projectLi.dataset.projectId;
            const projectTitle = projectLi.dataset.projectTitle;
            const projectDescription = projectLi.dataset.projectDescription;

            document.getElementById('update-project-id').value = projectId;
            document.getElementById('update-title').value = projectTitle;
            document.getElementById('update-description').value = projectDescription;

            updateProjectForm.classList.remove('hidden');
        });
    });

    if (closeUpdateProjectForm) {
        closeUpdateProjectForm.addEventListener('click', () => {
            updateProjectForm.classList.add('hidden');
        });
    }

    // Suppression de projet
    const btnRemoveProject = document.querySelectorAll('.btn-remove-project');

    btnRemoveProject.forEach(button => {
        button.addEventListener('click', (event) => {
            const projectLi = event.target.closest('.project-title');
            const projectId = projectLi.dataset.projectId;

            showConfirmationModal('Êtes-vous sûr de vouloir supprimer ce projet ?', function() {
                fetch(`remove_project.php?id=${projectId}`, {
                    method: 'DELETE'
                })
                .then(result => {
                    location.reload();
                })
                .catch(error => console.error('Erreur:', error));
            });
        });
    });

    // Modal Commentaire
    const commentModal = document.getElementById('commentModal');
    const commentModalClose = document.querySelector('#commentModal .close');

    window.openCommentModal = function(projectId) {
        document.getElementById('modalProjectId').value = projectId;
        commentModal.style.display = 'block';
    }

    if (commentModalClose) {
        commentModalClose.onclick = function() {
            commentModal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (event.target === commentModal) {
            commentModal.style.display = 'none';
        }
    }

    // Gestion des erreurs (modal)
    const errorModal = document.getElementById('errorModal');
    const errorModalClose = errorModal?.querySelector('.close');
    const errorMessage = document.getElementById('errorMessage');

    function showErrorModal(message) {
        errorMessage.textContent = message;
        errorModal.style.display = 'block';
    }

    if (errorModalClose) {
        errorModalClose.onclick = function() {
            errorModal.style.display = 'none';
        };
    }

    window.onclick = function(event) {
        if (event.target === errorModal) {
            errorModal.style.display = 'none';
        }
    }

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        showErrorModal(decodeURIComponent(error));
    }

    // Suppression de compte
    const deleteButtons = document.querySelectorAll('form[action="delete_account.php"] button[type="submit"]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            showConfirmationModal("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.", function() {
                this.closest('form').submit();
            });
        });
    });

    // Modal de confirmation
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmationModalClose = confirmationModal?.querySelector('.close');
    const confirmationMessage = document.getElementById('confirmationMessage');
    let confirmationCallback = null;

    function showConfirmationModal(message, callback) {
        confirmationMessage.textContent = message;
        confirmationModal.style.display = 'block';
        confirmationCallback = callback;
    }

    if (confirmationModalClose) {
        confirmationModalClose.onclick = function() {
            confirmationModal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (event.target === confirmationModal) {
            confirmationModal.style.display = 'none';
        }
    }

    document.getElementById('confirmationConfirmButton')?.addEventListener('click', function() {
        if (confirmationCallback) {
            confirmationCallback();
        }
        confirmationModal.style.display = 'none';
    });

    document.getElementById('confirmationCancelButton')?.addEventListener('click', function() {
        confirmationModal.style.display = 'none';
    });

    // Gestion du scroll
    window.addEventListener('scroll', function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    });

    window.addEventListener('load', function() {
        const savedPosition = localStorage.getItem('scrollPosition');
        if (savedPosition !== null) {
            window.scrollTo(0, parseInt(savedPosition, 10));
            localStorage.removeItem('scrollPosition');
        }
    });
});
