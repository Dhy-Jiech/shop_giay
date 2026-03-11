// public/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    // Basic Chatbot logic
    const chatToggle = document.getElementById('chatToggle');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatBtn = document.getElementById('chatBtn');
    const chatInput = document.getElementById('chatInput');
    const chatBody = document.getElementById('chatBody');

    if (chatToggle && chatWindow) {
        chatToggle.addEventListener('click', () => {
            chatWindow.classList.toggle('active');
        });

        closeChat.addEventListener('click', () => {
            chatWindow.classList.remove('active');
        });

        const appendMessage = (message, sender) => {
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('chat-message', sender === 'bot' ? 'bot-message' : 'user-message');
            msgDiv.textContent = message;
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        };

        const processBotResponse = (message) => {
            const lowerMsg = message.toLowerCase();
            let response = "Xin lỗi, tôi chưa hiểu rõ. Bạn có thể hỏi về: sản phẩm, vận chuyển, thanh toán, hoặc thông tin thương hiệu Đớ.";

            if (lowerMsg.includes('sản phẩm') || lowerMsg.includes('giày')) {
                response = "Đớ có các bộ sưu tập giày Sneaker và Thể thao chất lượng, thiết kế hiện đại và êm chân. Bạn xem thêm ở trang Danh sách nhé!";
            } else if (lowerMsg.includes('vận chuyển') || lowerMsg.includes('giao hàng') || lowerMsg.includes('ship')) {
                response = "Chúng tôi giao hàng toàn quốc. Phí ship tùy khu vực, thường dao động từ 20k - 40k. Thời gian giao từ 2-5 ngày.";
            } else if (lowerMsg.includes('thanh toán')) {
                response = "Đớ hỗ trợ thanh toán COD (nhận hàng trả tiền) và chuyển khoản ngân hàng.";
            } else if (lowerMsg.includes('thương hiệu') || lowerMsg.includes('đớ') || lowerMsg.includes('là ai')) {
                response = "Thương hiệu Đớ được thành lập với mong muốn mang đến những đôi giày hiện đại, tinh tế và thoải mái nhất cho giới trẻ Việt.";
            } else if (lowerMsg.includes('chào') || lowerMsg.includes('hi') || lowerMsg.includes('hello')) {
                response = "Chào bạn! Mình là AI hỗ trợ của Đớ. Mình có thể giúp gì cho bạn hôm nay?";
            }

            setTimeout(() => {
                appendMessage(response, 'bot');
            }, 600);
        };

        if (chatBtn && chatInput) {
            chatBtn.addEventListener('click', () => {
                const text = chatInput.value.trim();
                if (text) {
                    appendMessage(text, 'user');
                    chatInput.value = '';
                    processBotResponse(text);
                }
            });

            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    chatBtn.click();
                }
            });
        }
    }
});
// public/js/main.js

// Search form với debounce
const searchInput = document.querySelector('.search-input');
if (searchInput) {
    let debounceTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if (this.value.length >= 2) {
                // Gợi ý tìm kiếm (có thể gọi API)
                console.log('Searching for:', this.value);
            }
        }, 500);
    });
}

// Cart count animation
function updateCartCount(count) {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = count;
        cartCount.classList.add('pulse');
        setTimeout(() => {
            cartCount.classList.remove('pulse');
        }, 300);
    }
}

// Thêm CSS cho animation
const style = document.createElement('style');
style.textContent = `
    .cart-count.pulse {
        animation: pulse 0.3s ease;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(style);

// Dropdown menu cho mobile
if (window.innerWidth <= 768) {
    const navItems = document.querySelectorAll('.nav-item.has-megamenu > a');
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const megamenu = this.nextElementSibling;
            megamenu.style.display = megamenu.style.display === 'block' ? 'none' : 'block';
        });
    });
}

// Toast message function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Thêm animation cho slideOut
const slideOutStyle = document.createElement('style');
slideOutStyle.textContent = `
    @keyframes slideOutRight {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(slideOutStyle);

// Lazy load images
document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
});

// Add to cart animation
function addToCartAnimation(button) {
    const icon = button.querySelector('i');
    const originalClass = icon.className;

    icon.className = 'fas fa-check';
    button.classList.add('added');

    setTimeout(() => {
        icon.className = originalClass;
        button.classList.remove('added');
    }, 2000);

    // Update cart count
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const currentCount = parseInt(cartCount.textContent) || 0;
        updateCartCount(currentCount + 1);
    }
}