
    function getdatalies(product) {
        window.location.href = `detalies.php?id=${product.item_ID}&img=${encodeURIComponent(product.Image)}&File=${encodeURIComponent(product.File)}&name=${encodeURIComponent(product.Name)}&desc=${encodeURIComponent(product.Description)}&price=${product.price_sale}&country=${encodeURIComponent(product.Country_Made)}`;
    }
    
    function showDetaliesFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const product = {
            item_ID: urlParams.get('id'),
            Image: urlParams.get('img'),
            File_det: urlParams.get('File'),
            Name: urlParams.get('name'),
            Description: urlParams.get('desc'),
            price_sale: urlParams.get('price'),
            Country_Made: urlParams.get('country')
        };
    
        let detalies = document.getElementById('Detailes');
       if (product.File_det && product.File_det.trim() !== "") {
            window.location.href = `Admin/files/offers/${product.File_det}`;
             return;
        }else{

        detalies.innerHTML = `
            <div class="container w-100">
                <div class="box d-flex flex-wrap">
                    <div class="col-lg-6 img pt-5 pd-0 mb-0">
                        <img src="Admin/Layout/images/items/${product.Image}" alt="" style="width: 300px; height:300px ">
                    </div>
                    <div class="col-lg-6 detailes mb-5 pt-5 w-100">
                        <h2 class="title">${product.Name}</h2> <hr>
                        <h4 class="description"> ${product.Description}</h4><hr class="text-danger">
                        <div class="price badge badge-info mb-3"><h1>${product.price_sale} EGP</h1></div> <hr>
                        <div class=" h4 mb-3"> Made in ${product.Country_Made}</div> <hr>
                        <div class="btn btn-warning d-block" onclick="addToCart('${product.item_ID}', '${product.Name}', '${product.Image}', '${product.price_sale}')">Add To Cart</div>
                    </div>
                </div>
            </div>
        `;
        }
    }
    

    function getSearch() {
        let trbox = document.getElementsByClassName("trbox");
        let tditem = document.getElementsByClassName("tditem");
        let mainSection = document.getElementById("products");
        let hiddenSection = document.getElementById("hiddenSection");
        let search = document.getElementById("search").value.toUpperCase();
        let hero   = document.getElementById("hero");
        let found = false;
    
        hero.style.display="none";
        for (let i = 0; i < tditem.length; i++) {
            if (tditem[i].innerHTML.toUpperCase().indexOf(search) >= 0) {
                trbox[i].style.display = "block";
                found = true;
            } else {
                trbox[i].style.display = "none";
            }

        }
    
        if (!found) {

            mainSection.style.display ="none";
            hiddenSection.style.display ="block";
            hiddenSection.innerHTML = "<div class='text-center m-5 h4 text-danger'>No match found</div>";
        }
         else {
            mainSection.style.display = "grid";
            hiddenSection.style.display = "none";
            
        }
            if(search==''){
                hero.style.display="flex";
            }        
    }


 function filter(){
    const categoryButtons = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.card-product');
  
    categoryButtons.forEach(button => {
      button.addEventListener('click', () => {
        // إزالة active من جميع الأزرار
        categoryButtons.forEach(btn => btn.classList.remove('active'));
        // إضافة active للزر الحالي
        button.classList.add('active');
  
        const categoryId = button.getAttribute('data-id');
  
        productCards.forEach(card => {
          const cardCategory = card.getAttribute('data-category');
          if (categoryId === 'all' || cardCategory === categoryId) {
            card.style.display = "block";
          } else {
            card.style.display = "none";
          }
        });
      });
    });
}



let totalPrice = 0;


// دالة لتحديث عداد السلة
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalQuantity = 0;

    cart.forEach(item => {
        totalQuantity += item.quantity;
    });

    document.getElementById("cart-count").innerHTML = `<i class="fa-solid fa-cart-plus h5 p-2 bg-success" style="border-radius:20px"> ${totalQuantity} </i>`;
}

// دالة لإضافة منتج إلى السلة
function addToCart(id, name, image, price, quantity = 1) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let existingProduct = cart.find(item => item.id === id);

    if (existingProduct) {
        existingProduct.quantity += quantity;  // زياد الكمية بدل من 1
    } else {
        cart.push({
            id: id,
            name: name,
            image: image,
            price: price,
            quantity: quantity
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();  // تحديث عداد السلة
}

// دالة لعرض السلة
function displayCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartContainer = document.getElementById('cart-items');
    let totalPriceContainer = document.getElementById('total');
    cartContainer.innerHTML = "";  // تفريغ المحتوى قبل العرض
    totalPrice = 0;  // إعادة تعيين totalPrice

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p class='empty-message text-center text-muted '>Your cart is empty.</p>";
        totalPriceContainer.innerHTML = "<h3>Total Price: 0 EGP</h3>";
        return;
    }

    cart.forEach(item => {
        cartContainer.innerHTML += `
            <div class="cart-item d-flex   ">
                <img src="admin/layout/images/items/${item.image}" alt="${item.name}" style="width:100px; height:100px; object-fit:cover;">
                <div class="m-auto">
                    <h4>${item.name}</h4>
                    <p>Price: ${item.price} EGP</p>
                    <div class="d-flex align-items-center">
                        <button onclick="decreaseQuantity('${item.id}')" class="btn btn-sm btn-warning mr-2 px-3">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="increaseQuantity('${item.id}')" class="btn btn-sm btn-warning ml-2 px-3"> + </button>
                    </div>
                    <p>Total: ${item.price * item.quantity} EGP</p>
                </div>
                <div class='pt-2 '>
                    <button class="btn btn-outline-danger    mt-5" onclick="removeFromCart('${item.id}')"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        `;
        totalPrice += item.price * item.quantity;  // تحديث totalPrice
    });

    totalPriceContainer.innerHTML = `<h3>Total Price: ${totalPrice} EGP</h3>`;  // عرض totalPrice
    getnames();
}

// دالة لزيادة الكمية
function increaseQuantity(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart.find(item => item.id === id);
    if (product) {
        product.quantity += 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();  // إعادة عرض السلة
        updateCartCount();  // تحديث العداد
    }
}

// دالة لتقليل الكمية
function decreaseQuantity(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart.find(item => item.id === id);
    if (product && product.quantity > 1) {
        product.quantity -= 1;
    } else {
        cart = cart.filter(item => item.id !== id);  // حذف المنتج إذا كانت الكمية 1
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();  // إعادة عرض السلة
    updateCartCount();  // تحديث العداد
}

// دالة لإزالة منتج من السلة
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();  // إعادة عرض السلة
    updateCartCount();  // تحديث العداد
    getnames();
    
}

// دالة لتحديث أسماء المنتجات في input
function getnames() {
    let names = document.getElementById("Products_input_names");
    let sendedItems = "";
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart.length > 0) {
        for (let i = 0; i < cart.length; i++) {
            sendedItems += `${cart[i].id}->${cart[i].name}=>${cart[i].quantity}; `;
        }
        names.value = sendedItems;  // تحديث الـ input
    }else{
        names.value='';
    }
}

// دالة لإظهار تفاصيل المنتج بناءً على URL


// إذا كانت السلة تحتوي على منتجات، اعرضها
if (type=='cart') {
    displayCart();
}



function clear() {
    localStorage.clear(); // لو السلة محفوظة في localStorage
    // أو
    document.getElementById('cart-items').innerHTML = '';
    updateCartCount();
    calculateTotal();
}

