</main>

<!-- TAMBAHAN ID="KONTAK" DISINI AGAR LINK HEADER BISA MENGARAH KE SINI -->
<footer id="kontak" class="footer-section">
    <div class="footer-container">
        
        <div class="footer-grid">
            
            <div class="footer-col-logo">
                <div class="logo-text-wrapper footer-logo">
                    <span class="logo-siomay">Siomay</span>
                    <span class="logo-duaputri">Dua Putri</span>
                    <span class="logo-since">Sejak 2018</span>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Alamat</h4>
                <p class="footer-text">
                    Kantin RSUD Undata<br>
                    Sulawesi Tengah
                </p>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Hubungi Kami</h4>
                <ul class="footer-list">
                    <li>
                        <span class="material-symbols-outlined">call</span>
                        082292590290
                    </li>
                    <li>
                        <span class="material-symbols-outlined">alternate_email</span>
                        fb : Siomay Dhua Putri
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Jam Buka</h4>
                <p class="footer-text">
                    10.00 - 21.00 Wita<br>
                    Setiap Hari
                </p>
            </div>

            <div class="footer-col footer-socials">
                <a href="#" class="social-circle" title="WhatsApp">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.177-.298-.018-.46.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a5.8 5.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
                <a href="#" class="social-circle" title="Facebook">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
            </div>

        </div>

        <div class="footer-bottom">
            <span>© <?= date('Y') ?> Siomay Dua Putri. All Rights Reserved.</span>
        </div>
    </div>
</footer>

<style>
    /* === Footer Styles === */
    .footer-section {
        background-color: #3b198f; 
        width: 100%;
        padding: 50px 40px 20px;
        margin-top: 60px;
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
    }
    
    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }

    @media (min-width: 992px) {
        .footer-grid { 
            grid-template-columns: 1.5fr 1fr 1.2fr 1fr auto; 
            align-items: start;
        }
    }

    .footer-logo { width: max-content; }
    .footer-logo .logo-siomay,
    .footer-logo .logo-duaputri { color: #ffffff; }
    
    .footer-logo .logo-since {
        color: #ffffff;
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        width: 100%;
        gap: 8px;
        margin-top: 8px;
    }
    .footer-logo .logo-since::before {
        content: "";
        height: 1px;
        flex: 1; 
        background-color: #ffffff;
        opacity: 0.7;
    }
    .footer-logo .logo-since::after {
        content: "";
        height: 1px;
        flex: 3; 
        background-color: #ffffff;
        opacity: 0.7;
    }

    .footer-heading {
        font-weight: 700;
        margin: 0 0 12px;
        font-size: 0.95rem;
    }
    .footer-text {
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.6;
        opacity: 0.9;
    }
    .footer-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 0.85rem;
        opacity: 0.9;
    }
    .footer-list li {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .footer-list .material-symbols-outlined { font-size: 18px; }

    .footer-socials {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .social-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #ffffff;
        color: #3b198f; 
        border-radius: 50%;
        transition: transform 0.2s ease-in-out;
    }
    .social-circle:hover { transform: scale(1.1); }

    .footer-bottom {
        text-align: center;
        font-size: 0.8rem;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        opacity: 0.8;
    }
</style>

</body>
</html>