<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>ĐỚ Store</h3>
                <p>Thương hiệu giày thể thao Việt Nam với thiết kế độc quyền và chất lượng cao cấp.</p>
            </div>
            <div class="footer-section">
                <h4>Liên hệ</h4>
                <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, Hà Nội</p>
                <p><i class="fas fa-phone"></i> 1900 1234</p>
                <p><i class="fas fa-envelope"></i> info@dostore.vn</p>
            </div>
            <div class="footer-section">
                <h4>Theo dõi chúng tôi</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 ĐỚ Store. All rights reserved.</p>
        </div>
    </div>
</footer>

<div id="ai-chat-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <button id="ai-chat-toggle" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ff4d4d 0%, #d32f2f 100%); color: white; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-robot" style="font-size: 24px;"></i>
    </button>

    <div id="ai-chat-window" style="display: none; width: 350px; height: 450px; background: white; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); margin-bottom: 15px; flex-direction: column; overflow: hidden; position: absolute; bottom: 75px; right: 0;">
        <div style="background: #d32f2f; padding: 15px; color: white; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: bold;"><i class="fas fa-bolt"></i> Trợ lý ĐỚ Store</span>
            <button id="close-chat" style="background: none; border: none; color: white; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <div id="ai-chat-content" style="flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; display: flex; flex-direction: column; gap: 10px; font-size: 0.9rem;">
            <div style="background: #eee; padding: 10px; border-radius: 10px; align-self: flex-start; max-width: 85%;">
                Chào bạn! Mình là AI của ĐỚ Store. Mình có thể giúp gì cho bạn?
            </div>
        </div>

        <div style="padding: 12px; border-top: 1px solid #eee; display: flex; background: white;">
<input type="text" id="ai-chat-input" placeholder="Hỏi về size giày, giá..." style="flex: 1; border: 1px solid #ddd; padding: 10px 15px; border-radius: 25px; outline: none;">
            <button id="ai-send-btn" style="background: #d32f2f; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; margin-left: 8px; cursor: pointer;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('ai-chat-toggle');
    const chatWindow = document.getElementById('ai-chat-window');
    const closeChat = document.getElementById('close-chat');
    const chatInput = document.getElementById('ai-chat-input');
    const sendBtn = document.getElementById('ai-send-btn');
    const chatContent = document.getElementById('ai-chat-content');

    // Ẩn/Hiện cửa sổ chat
    chatToggle.onclick = () => {
        chatWindow.style.display = (chatWindow.style.display === 'none') ? 'flex' : 'none';
    };
    closeChat.onclick = () => chatWindow.style.display = 'none';

    async function handleChat() {
        const message = chatInput.value.trim();
        if(!message) return;

        // 1. Hiển thị tin nhắn của người dùng
        chatContent.innerHTML += `<div style="background: #d32f2f; color: white; padding: 10px; border-radius: 10px; align-self: flex-end; max-width: 85%;">${message}</div>`;
        chatInput.value = '';
        chatContent.scrollTop = chatContent.scrollHeight;

        // 2. Trạng thái chờ xử lý
        const loading = document.createElement('div');
        loading.style = "background: #eee; padding: 10px; border-radius: 10px; align-self: flex-start; font-style: italic;";
        loading.innerText = "Đang kết nối AI...";
        chatContent.appendChild(loading);

        try {
            // 3. Gọi đến Controller qua index.php?url=ai/chat
            const response = await fetch('index.php?url=ai/chat', { 
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            loading.remove();
            
            // Tìm đến hàm handleChat() trong script của file footer.php
// Thay đổi phần hiển thị kết quả như sau:

if(data.reply) {
    // SỬ DỤNG innerHTML để hiển thị link có thể nhấp vào
    chatContent.innerHTML += `
        <div style="background: #eee; padding: 10px; border-radius: 10px; align-self: flex-start; max-width: 85%; line-height: 1.6; color: #333;">
            ${data.reply}
        </div>`;
}
        } catch (e) {
            loading.innerText = "Lỗi kết nối AI!";
            console.error("DEBUG LỖI CHATBOT:", e);
        }
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    sendBtn.onclick = handleChat;
chatInput.onkeypress = (e) => { if(e.key === 'Enter') handleChat(); };
});
</script>

<style>
/* Footer Styling - Tông màu đỏ ĐỚ Store */
.footer { background: #000000; color: white; padding: 40px 0 20px; margin-top: 60px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.footer-content { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 30px; }
.footer-section h3, .footer-section h4 { color: white; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
.footer-section p { margin-bottom: 8px; opacity: 0.9; line-height: 1.5; }
.footer-section i { margin-right: 10px; color: #ffffff; }
.social-links { display: flex; gap: 15px; }
.social-links a { color: white; font-size: 1.3rem; transition: transform 0.3s; }
.social-links a:hover { transform: scale(1.2); color: #ffeb3b; }
.footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); opacity: 0.8; font-size: 0.85rem; }

/* Responsive */
@media (max-width: 768px) {
    .footer-content { grid-template-columns: 1fr; text-align: center; }
    .social-links { justify-content: center; }
}
</style>