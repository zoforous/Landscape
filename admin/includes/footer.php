</main>

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <div class="footer-logo">
                <i class="fas fa-leaf"></i> GreenScape
            </div>
            <p class="footer-tagline">Transform your outdoor space</p>
        </div>

        <div class="footer-section">
            <div class="footer-stats">
                <div class="stat-item">
                    <i class="fas fa-user"></i>
                    <span>Logged in as: <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-clock"></i>
                    <span>UTC: <?= date('Y-m-d H:i:s'); ?></span>
                </div>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-links">
                <a href="../index.php"><i class="fas fa-home"></i> Home</a>
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="../user/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y'); ?> GreenScape Landscaping. All rights reserved.</p>
    </div>
</footer>

<style>
.site-footer {
    background: var(--dark-color);
    color: white;
    padding: 2rem 0 1rem;
    margin-top: auto;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 2rem;
    padding: 0 2rem;
}

.footer-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.footer-logo {
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.footer-logo i {
    color: var(--primary-color);
}

.footer-tagline {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.footer-stats {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.stat-item i {
    color: var(--primary-color);
}

.footer-links {
    display: flex;
    gap: 1.5rem;
    justify-content: flex-end;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.footer-links a:hover {
    color: var(--primary-color);
    transform: translateY(-2px);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 2rem;
    padding-top: 1rem;
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1.5rem;
    }

    .footer-logo {
        justify-content: center;
    }

    .footer-stats {
        align-items: center;
    }

    .footer-links {
        justify-content: center;
        flex-wrap: wrap;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update time every second
    function updateTime() {
        const timeElement = document.querySelector('.stat-item .fa-clock').nextElementSibling;
        const now = new Date();
        const utcString = now.toISOString().slice(0, 19).replace('T', ' ');
        timeElement.textContent = 'UTC: ' + utcString;
    }

    setInterval(updateTime, 1000);

    // Add hover animations for footer links
    const footerLinks = document.querySelectorAll('.footer-links a');
    footerLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.style.transform = 'translateY(-3px)';
        });
        link.addEventListener('mouseleave', () => {
            link.style.transform = 'translateY(0)';
        });
    });
});
</script>

</body>
</html>