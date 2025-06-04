<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Kantin SMK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html { scroll-behavior: smooth; }
    body { padding-top: 70px; }
    section { padding: 80px 0; }
    footer { background-color: #f8f9fa; text-align: center; padding: 20px; }
    .stok { font-size: 0.9rem; color: gray; }
    #qr-section { display: none; }
  </style>
</head>
<body>
  <!-- Navbar dan bagian lainnya tetap sama -->

  <!-- How to Buy -->
  <section id="howtobuy" class="bg-light">
    <div class="container text-center">
      <h2>Cara Pemesanan</h2>
      <form id="orderForm" onsubmit="return handleOrder(event)">
        <div class="row justify-content-center">
          <div class="col-md-6 text-start">
            <label>Menu:</label>
            <div class="mb-3">
              <!-- Menu akan dimuat dengan JS -->
            </div>
            <button class="btn btn-success">Order Now</button>
            <div class="mt-3">
              <strong>Total Harga:</strong> <span id="totalHarga">Rp0</span>
            </div>
          </div>
        </div>
      </form>
      <div id="qr-section" class="mt-4">
        <h5>QR Code Pembayaran</h5>
        <img src="img/qr_dummy.png" width="180" alt="QR Dummy">
      </div>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetch("get_menu.php")
        .then(response => response.json())
        .then(data => {
          const container = document.querySelector("#howtobuy .mb-3");
          container.innerHTML = "";
          window.menuList = [];
          data.forEach(menu => {
            window.menuList.push(menu);
            const div = document.createElement("div");
            div.className = "mb-2";
            div.innerHTML = `
              <label>
                ${menu.nama} (Rp${menu.harga}) - Stok: <span class="stok-value" data-id="${menu.id}">${menu.stok}</span>
              </label>
              <input type="number" class="form-control" name="qty_${menu.id}" value="0" min="0" max="${menu.stok}">
            `;
            container.appendChild(div);
          });
        });
    });

    function handleOrder(e) {
      e.preventDefault();
      const items = [];
      let total = 0;
      if (!window.menuList) return;
      window.menuList.forEach(menu => {
        const qty = parseInt(document.querySelector(`[name='qty_${menu.id}']`).value) || 0;
        if (qty > 0) {
          items.push({ id: menu.id, qty });
          total += menu.harga * qty;
        }
      });
      document.getElementById("totalHarga").textContent = "Rp" + total.toLocaleString();
      if (items.length > 0) {
        fetch("pesan.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ items, total })
        })
        .then(res => res.json())
        .then(res => {
          if (res.success) {
            document.getElementById("qr-section").style.display = 'block';
            items.forEach(item => {
              const stokEl = document.querySelector(`.stok-value[data-id='${item.id}']`);
              const oldStok = parseInt(stokEl.textContent);
              stokEl.textContent = oldStok - item.qty;
              document.querySelector(`[name='qty_${item.id}']`).value = 0;
            });
          }
        });
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
