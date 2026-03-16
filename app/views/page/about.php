<?php include 'app/views/layouts/header.php'; ?>

<style>
    .about-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }
    
    .brand-name {
        font-size: 5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        letter-spacing: 2px;
    }
    
    .quote-text {
        font-size: 1.5rem;
        font-style: italic;
        color: var(--text-muted);
        border-left: 4px solid var(--primary-color);
        padding-left: 2rem;
        margin: 2rem 0;
    }
    
    .story-card {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    
    .story-card:hover {
        transform: translateY(-5px);
    }
    
    .highlight-text {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #2d3748;
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .stat-box {
        background: linear-gradient(135deg, var(--primary-color), #6366f1);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="about-section">
    <div class="container">
        <!-- Hero Section -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <h1 class="brand-name">ĐỚ</h1>
            <div class="quote-text" style="max-width: 700px; margin: 2rem auto;">
                "Đớ" không đơn thuần là một cái tên, đó là một trạng thái.
            </div>
            <p style="font-size: 1.25rem; color: var(--text-muted); max-width: 600px; margin: 0 auto;">
                Hành trình mang đến sự tự tin trên từng bước chân.
            </p>
        </div>

        <!-- Main Content -->
        <div class="row" style="gap: 3rem; align-items: center;">
            <div class="col-md-6 floating">
                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&q=80&w=800" 
                     alt="Đớ Brand Detail" 
                     style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            </div>
            
            <div class="col-md-6">
                <div class="story-card">
                    <h2 style="color: var(--primary-color); font-size: 2rem; margin-bottom: 1.5rem; font-weight: 700;">
                        Câu Chuyện Của Chúng Mình
                    </h2>
                    
                    <p class="highlight-text">
                        Ra đời giữa lòng nhịp sống hối hả của năm 2024, <strong>ĐỚ</strong> bắt đầu từ một câu hỏi đơn giản: 
                        "Làm sao để mỗi bước chân đều mang theo sự tự do tuyệt đối?".
                    </p>
                    
                    <p class="highlight-text">
                        Chúng mình không chạy theo những xu hướng nhất thời. Tại ĐỚ, mỗi đôi giày là sự giao thoa giữa 
                        <strong>Nghệ thuật tối giản</strong> và <strong>Công năng bền bỉ</strong>. Chúng tôi tin rằng, 
                        một đôi giày tốt không chỉ bảo vệ đôi chân, mà còn là người bạn đồng hành cùng bạn chinh phục 
                        những nốt thăng trầm của tuổi trẻ.
                    </p>
                    
                    <p class="highlight-text">
                        Từ khâu chọn chất liệu da mềm mại đến những đường kim mũi chỉ thủ công, ĐỚ gói ghém sự tận tâm 
                        vào từng hộp giày, với hy vọng khi bạn xỏ chân vào, bạn sẽ cảm thấy: 
                        <strong>Là chính mình, một cách thoải mái nhất.</strong>
                    </p>
                    
                    <div style="display: flex; gap: 2rem; margin-top: 2.5rem;">
                        <div class="stat-box" style="flex: 1;">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Dấu chân đồng hành</div>
                        </div>
                        <div class="stat-box" style="flex: 1; background: linear-gradient(135deg, #6366f1, var(--primary-color));">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Cảm hứng thiết kế</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Quote -->
        <div style="text-align: center; margin-top: 4rem; padding: 2rem; background: white; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.03);">
            <p style="font-size: 1.3rem; color: #4a5568; font-style: italic;">
                "Không chỉ là giày, đó là tuyên ngôn của chính bạn."
            </p>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>