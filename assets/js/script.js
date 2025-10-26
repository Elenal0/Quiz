// filename: assets/js/script.js
document.addEventListener('DOMContentLoaded', function() {
    // Mobile navigation toggle
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    isValid = false;
                } else {
                    field.classList.remove('error');
                }
            });

            // Email validation
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(field => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (field.value && !emailRegex.test(field.value)) {
                    field.classList.add('error');
                    isValid = false;
                }
            });

            // Password validation
            const passwordFields = form.querySelectorAll('input[type="password"]');
            passwordFields.forEach(field => {
                if (field.name === 'password' && field.value.length < 8) {
                    field.classList.add('error');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
    });

    // Quiz functionality
    if (document.querySelector('.quiz-container')) {
        initializeQuiz();
    }

    // Speedometer gauge
    if (document.querySelector('.speedometer-container')) {
        const scoreElement = document.querySelector('.score-display');
        if (scoreElement) {
            const scoreText = scoreElement.textContent;
            const scoreMatch = scoreText.match(/(\d+)\/(\d+)/);
            if (scoreMatch) {
                const score = parseInt(scoreMatch[1]);
                const total = parseInt(scoreMatch[2]);
                const percentage = (score / total) * 100;
                createSpeedometer('.speedometer-container', percentage, score, total);
            }
        }
    }

    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
});


function initializeQuiz() {
    const questions = JSON.parse(document.getElementById('quiz-data').textContent);
    let currentQuestion = 0;
    let userAnswers = {};
    let quizSubmitted = false;

    function showQuestion(index) {
        const question = questions[index];
        const container = document.querySelector('.question-container');
        
        // Update progress bar
        const progressBar = document.querySelector('.quiz-progress-bar');
        const progress = ((index + 1) / questions.length) * 100;
        progressBar.style.width = progress + '%';
        
        // Build question HTML
        const questionHtml = `
            <div class="question-number">Question ${index + 1} of ${questions.length}</div>
            <div class="question-text">${question.question_text}</div>
            <div class="options">
                <label class="option" data-option="a">
                    <input type="radio" name="answer" value="a" ${userAnswers[index] === 'a' ? 'checked' : ''}>
                    <span>${question.option_a}</span>
                </label>
                <label class="option" data-option="b">
                    <input type="radio" name="answer" value="b" ${userAnswers[index] === 'b' ? 'checked' : ''}>
                    <span>${question.option_b}</span>
                </label>
                <label class="option" data-option="c">
                    <input type="radio" name="answer" value="c" ${userAnswers[index] === 'c' ? 'checked' : ''}>
                    <span>${question.option_c}</span>
                </label>
                <label class="option" data-option="d">
                    <input type="radio" name="answer" value="d" ${userAnswers[index] === 'd' ? 'checked' : ''}>
                    <span>${question.option_d}</span>
                </label>
            </div>
        `;
        
        container.innerHTML = questionHtml;

        // Add event listeners to options
        const options = container.querySelectorAll('.option');
        options.forEach(option => {
            option.addEventListener('click', function() {
                if (quizSubmitted) return;
                
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove selected class from all options
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                // Store user answer
                userAnswers[currentQuestion] = radio.value;
                
                // Show correct/incorrect after selection
                if (quizSubmitted) {
                    showAnswerFeedback(currentQuestion);
                }
            });
        });

        // Update navigation buttons
        updateNavigation();
        
        // Show answer feedback if quiz is submitted
        if (quizSubmitted) {
            showAnswerFeedback(currentQuestion);
        }
    }

    function showAnswerFeedback(questionIndex) {
        const question = questions[questionIndex];
        const options = document.querySelectorAll('.option');
        const correctAnswer = question.correct_option;
        const userAnswer = userAnswers[questionIndex];

        options.forEach(option => {
            const optionValue = option.getAttribute('data-option');
            const radio = option.querySelector('input[type="radio"]');
            
            // Disable all radio buttons
            radio.disabled = true;
            
            if (optionValue === correctAnswer) {
                option.classList.add('correct');
            } else if (optionValue === userAnswer && userAnswer !== correctAnswer) {
                option.classList.add('incorrect');
            }
        });
    }

    function updateNavigation() {
        const prevBtn = document.querySelector('.btn-prev');
        const nextBtn = document.querySelector('.btn-next');
        const submitBtn = document.querySelector('.btn-submit');

        if (prevBtn) {
            prevBtn.style.display = currentQuestion === 0 ? 'none' : 'inline-block';
        }

        if (nextBtn) {
            nextBtn.style.display = currentQuestion === questions.length - 1 ? 'none' : 'inline-block';
        }

        if (submitBtn) {
            submitBtn.style.display = currentQuestion === questions.length - 1 ? 'inline-block' : 'none';
        }
    }

    // Navigation event listeners
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-prev')) {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        }

        if (e.target.classList.contains('btn-next')) {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        }

        if (e.target.classList.contains('btn-submit')) {
            submitQuiz();
        }
    });

    function submitQuiz() {
        quizSubmitted = true;

        // Calculate score
        let correctAnswers = 0;
        questions.forEach((question, index) => {
            if (userAnswers[index] === question.correct_option) {
                correctAnswers++;
            }
        });

        // Show feedback for current question
        showAnswerFeedback(currentQuestion);

        // Populate hidden form fields if exist
        const answersInput = document.getElementById('answers-input');
        if (answersInput) answersInput.value = JSON.stringify(userAnswers);
        const scoreInput = document.getElementById('score-input');
        if (scoreInput) scoreInput.value = correctAnswers;
        const totalInput = document.getElementById('total-input');
        if (totalInput) totalInput.value = questions.length;

        // Submit the form if exists
        const form = document.getElementById('quiz-submit-form');
        if (form) {
            form.submit();
        }

        // Submit to server via fetch as fallback/async option
        const formData = new FormData();
        formData.append('topic', new URLSearchParams(window.location.search).get('topic'));
        formData.append('answers', JSON.stringify(userAnswers));
        formData.append('score', correctAnswers);
        formData.append('total', questions.length);

        fetch('results.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to results page
                window.location.href = `results.php?attempt_id=${data.attempt_id}`;
            } else {
                showAlert('Error submitting quiz. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error submitting quiz. Please try again.', 'error');
        });
    }

    // Initialize first question
    showQuestion(0);
}


function createSpeedometer(container, percentage, score, total) {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', '100%');
    svg.setAttribute('height', '100%');
    svg.setAttribute('viewBox', '0 0 300 200');

    // Background arc
    const backgroundArc = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    backgroundArc.setAttribute('d', 'M 30 150 A 120 120 0 0 1 270 150');
    backgroundArc.setAttribute('stroke', '#e2e8f0');
    backgroundArc.setAttribute('stroke-width', '20');
    backgroundArc.setAttribute('fill', 'none');
    svg.appendChild(backgroundArc);

    // Progress arc
    const progressArc = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    const angle = (percentage / 100) * 180;
    const radians = (angle - 90) * (Math.PI / 180);
    const x = 150 + 120 * Math.cos(radians);
    const y = 150 + 120 * Math.sin(radians);
    const largeArc = angle > 180 ? 1 : 0;
    progressArc.setAttribute('d', `M 30 150 A 120 120 0 ${largeArc} 1 ${x} ${y}`);

    let color = '#ef4444';
    if (percentage >= 80) color = '#10b981'; // Green
    else if (percentage >= 60) color = '#f59e0b'; // Yellow

    progressArc.setAttribute('stroke', color);
    progressArc.setAttribute('stroke-width', '20');
    progressArc.setAttribute('fill', 'none');
    progressArc.setAttribute('stroke-linecap', 'round');
    svg.appendChild(progressArc);

    // Center circle
    const centerCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    centerCircle.setAttribute('cx', '150');
    centerCircle.setAttribute('cy', '150');
    centerCircle.setAttribute('r', '8');
    centerCircle.setAttribute('fill', '#64748b');
    svg.appendChild(centerCircle);

    // Needle
    const needle = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    const needleAngle = (percentage / 100) * 180 - 90;
    const needleRadians = needleAngle * (Math.PI / 180);
    const needleX = 150 + 100 * Math.cos(needleRadians);
    const needleY = 150 + 100 * Math.sin(needleRadians);

    needle.setAttribute('x1', '150');
    needle.setAttribute('y1', '150');
    needle.setAttribute('x2', needleX);
    needle.setAttribute('y2', needleY);
    needle.setAttribute('stroke', '#1e293b');
    needle.setAttribute('stroke-width', '3');
    needle.setAttribute('stroke-linecap', 'round');
    svg.appendChild(needle);

    // Score text
    const scoreText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    scoreText.setAttribute('x', '150');
    scoreText.setAttribute('y', '180');
    scoreText.setAttribute('text-anchor', 'middle');
    scoreText.setAttribute('font-size', '24');
    scoreText.setAttribute('font-weight', 'bold');
    scoreText.setAttribute('fill', color);
    scoreText.textContent = `${score}/${total}`;
    svg.appendChild(scoreText);

    // Percentage text
    const percentText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    percentText.setAttribute('x', '150');
    percentText.setAttribute('y', '195');
    percentText.setAttribute('text-anchor', 'middle');
    percentText.setAttribute('font-size', '14');
    percentText.setAttribute('fill', '#64748b');
    percentText.textContent = `${Math.round(percentage)}%`;
    svg.appendChild(percentText);

    // Add scale markers
    for (let i = 0; i <= 10; i++) {
        const markerAngle = (i / 10) * 180 - 90;
        const markerRadians = markerAngle * (Math.PI / 180);
        const x1 = 150 + 110 * Math.cos(markerRadians);
        const y1 = 150 + 110 * Math.sin(markerRadians);
        const x2 = 150 + 125 * Math.cos(markerRadians);
        const y2 = 150 + 125 * Math.sin(markerRadians);
        
        const marker = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        marker.setAttribute('x1', x1);
        marker.setAttribute('y1', y1);
        marker.setAttribute('x2', x2);
        marker.setAttribute('y2', y2);
        marker.setAttribute('stroke', '#64748b');
        marker.setAttribute('stroke-width', i % 5 === 0 ? '2' : '1');
        svg.appendChild(marker);

        // Add numbers for major markers
        if (i % 5 === 0) {
            const numberX = 150 + 135 * Math.cos(markerRadians);
            const numberY = 150 + 135 * Math.sin(markerRadians) + 5;
            const numberText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            numberText.setAttribute('x', numberX);
            numberText.setAttribute('y', numberY);
            numberText.setAttribute('text-anchor', 'middle');
            numberText.setAttribute('font-size', '12');
            numberText.setAttribute('fill', '#64748b');
            numberText.textContent = i;
            svg.appendChild(numberText);
        }
    }

    document.querySelector(container).appendChild(svg);

    // Animate the needle and arc
    progressArc.style.strokeDasharray = '0 1000';
    needle.style.opacity = '0';

    setTimeout(() => {
        progressArc.style.transition = 'stroke-dasharray 2s ease-out';
        needle.style.transition = 'opacity 0.5s ease-in';
        
        const arcLength = (percentage / 100) * 754; // Approximate arc length
        progressArc.style.strokeDasharray = `${arcLength} 1000`;
        needle.style.opacity = '1';
    }, 100);
}


function showAlert(message, type = 'info') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    // Insert at the beginning of main content
    const main = document.querySelector('main');
    if (main) {
        main.insertBefore(alert, main.firstChild);
    } else {
        document.body.insertBefore(alert, document.body.firstChild);
    }
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export functions for other scripts to use
window.QuizApp = {
    showAlert,
    formatDate,
    createSpeedometer,
    debounce
};
