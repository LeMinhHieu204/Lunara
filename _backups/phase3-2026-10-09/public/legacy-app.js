const ICONS = {
  truck: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h11v11H3zM14 10h4l3 3v4h-7zM6.5 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM17.5 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>',
  shield: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 20 6v5c0 5.1-3.4 8.8-8 10-4.6-1.2-8-4.9-8-10V6l8-3Z"/><path d="m8.5 12 2.2 2.2 4.8-4.8"/></svg>',
  return: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 2.6-6.4"/><path d="M3 4v6h6"/></svg>',
  headset: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14v-2a8 8 0 0 1 16 0v2"/><path d="M4 14h3v5H5a1 1 0 0 1-1-1v-4ZM20 14h-3v5h2a1 1 0 0 0 1-1v-4Z"/><path d="M17 19c0 1.1-1.5 2-3.5 2"/></svg>',
  search: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>',
  user: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="7.5" r="3.5"/><path d="M4.5 20c.6-3.4 3.2-5.5 7.5-5.5s6.9 2.1 7.5 5.5"/></svg>',
  heart: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 8.8c0 5-8.8 10.1-8.8 10.1S3.2 13.8 3.2 8.8A4.6 4.6 0 0 1 12 6.5a4.6 4.6 0 0 1 8.8 2.3Z"/></svg>',
  cart: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.1 11.1a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.5L20.5 8H6"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>',
  menu: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>',
  close: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="m6 6 12 12M18 6 6 18"/></svg>',
  arrow: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h15M13 6l6 6-6 6"/></svg>',
  chevron: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m8 10 4 4 4-4"/></svg>',
  chevronLeft: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m14 6-6 6 6 6"/></svg>',
  chevronRight: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m10 6 6 6-6 6"/></svg>',
  leaf: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 4C9 4 4 9 4 16c0 2.2 1.8 4 4 4 7 0 12-5 12-16Z"/><path d="M4 20 15 9"/></svg>',
  star: '<svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m12 3 2.8 5.8 6.2.9-4.5 4.5 1.1 6.2-5.6-2.9-5.6 2.9 1.1-6.2L3 9.7l6.2-.9L12 3Z"/></svg>',
  globe: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.2 2.5 3.3 5.5 3.3 9s-1.1 6.5-3.3 9c-2.2-2.5-3.3-5.5-3.3-9S9.8 5.5 12 3Z"/></svg>',
  mail: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>',
  spark: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7L12 3ZM19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8L19 16Z"/></svg>',
  instagram: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><rect x="3.5" y="3.5" width="17" height="17" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.6" cy="6.5" r=".7" fill="currentColor" stroke="none"/></svg>',
  facebook: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.4-.1-2.6-.1-2.6 0-4.3 1.6-4.3 4.4V10H7.3v3h2.8v8h3.4Z"/></svg>',
  linkedin: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M5.1 8.6H2V21h3.1V8.6ZM3.5 3A1.8 1.8 0 1 0 3.5 6.6 1.8 1.8 0 0 0 3.5 3ZM9 8.6H6V21h3.1v-6.1c0-1.6.3-3.2 2.3-3.2 1.9 0 1.9 1.8 1.9 3.3V21h3.1v-6.7c0-3.3-.7-5.9-4.6-5.9-1.8 0-3 .9-3.5 1.8h-.1V8.6Z"/></svg>',
  userGroup: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="9" cy="8" r="3"/><path d="M3.5 20c.5-3.1 2.3-5 5.5-5s5 1.9 5.5 5M17 11a3 3 0 1 0 0-6M16 15c2.6.1 4.1 1.7 4.5 4"/></svg>'
};

const icon = (name) => ICONS[name] || '';

const assets = [
  'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1506629905607-d9c297d2f2f1?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1566206091558-7f218b696731?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=800&q=86&sat=-12',
  'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1585488435967-26c3a53bc1f1?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1541101767792-f9b2b1c4f127?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1556228578-8c89e6adf883?auto=format&fit=crop&w=800&q=86',
  'https://images.unsplash.com/photo-1547887538-e3a2f32cb1cc?auto=format&fit=crop&w=800&q=86'
];

const categoryData = [
  { slug: 'clothing', name: 'Clothing', count: 32, image: assets[1] },
  { slug: 'bags', name: 'Bags', count: 18, image: assets[6] },
  { slug: 'shoes', name: 'Shoes', count: 15, image: assets[5] },
  { slug: 'accessories', name: 'Accessories', count: 20, image: assets[7] },
  { slug: 'beauty', name: 'Beauty', count: 16, image: assets[22] },
  { slug: 'hats', name: 'Hats', count: 8, image: assets[14] }
];

const seedProducts = [
  { id: 'linen-oversize-shirt', slug: 'linen-oversize-shirt', name: 'Linen Oversize Shirt', category: 'clothing', price: 49.99, compare: null, image: assets[1], rating: 4.8, reviews: 128, newArrival: true, description: 'A relaxed linen layer designed for light, easy days. Cut generously with a softly structured collar and natural texture.' },
  { id: 'minimal-tote-bag', slug: 'minimal-tote-bag', name: 'Minimal Tote Bag', category: 'bags', price: 59.99, compare: null, image: assets[6], rating: 4.7, reviews: 96, newArrival: true, description: 'An everyday tote with room for everything that matters. Finished in supple, durable vegan leather.' },
  { id: 'classic-white-sneakers', slug: 'classic-white-sneakers', name: 'Classic White Sneakers', category: 'shoes', price: 69.99, compare: 79.99, image: assets[5], rating: 4.9, reviews: 215, newArrival: true, onSale: true, description: 'Clean lines, considered comfort and a versatile low profile for every wardrobe.' },
  { id: 'knit-sweater', slug: 'knit-sweater', name: 'Knit Sweater', category: 'clothing', price: 44.99, compare: null, image: assets[0], rating: 4.8, reviews: 112, newArrival: true, description: 'A soft, warm knit with a lightly relaxed fit. An effortless essential for slow mornings and cool evenings.' },
  { id: 'eau-de-parfum', slug: 'eau-de-parfum', name: 'Eau de Parfum', category: 'beauty', price: 39.99, compare: null, image: assets[23], rating: 4.7, reviews: 67, newArrival: true, description: 'A skin-close fragrance with luminous citrus, quiet woods and a warm, lasting finish.' },
  { id: 'sunglasses', slug: 'sunglasses', name: 'Sunglasses', category: 'accessories', price: 29.99, compare: null, image: assets[7], rating: 4.8, reviews: 87, description: 'Modern acetate frames with a softly rounded silhouette and everyday UV protection.' },
  { id: 'hydrating-serum', slug: 'hydrating-serum', name: 'Hydrating Serum', category: 'beauty', price: 24.99, compare: null, image: assets[22], rating: 4.6, reviews: 67, description: 'A lightweight daily serum made to leave skin feeling balanced, fresh and comfortably hydrated.' },
  { id: 'classic-baseball-cap', slug: 'classic-baseball-cap', name: 'Classic Baseball Cap', category: 'hats', price: 19.99, compare: null, image: assets[14], rating: 4.6, reviews: 45, description: 'A clean six-panel cap with a softly curved brim and an adjustable back strap.' },
  { id: 'ribbed-cardigan', slug: 'ribbed-cardigan', name: 'Ribbed Cardigan', category: 'clothing', price: 54.99, compare: null, image: assets[2], rating: 4.7, reviews: 75, description: 'A tactile ribbed cardigan with a gentle drape and just the right amount of structure.' },
  { id: 'satin-slip-dress', slug: 'satin-slip-dress', name: 'Satin Slip Dress', category: 'clothing', price: 59.99, compare: 69.99, image: assets[3], rating: 4.8, reviews: 98, onSale: true, description: 'A softly fluid slip dress made for evenings, layered days and everything in between.' },
  { id: 'shoulder-bag', slug: 'shoulder-bag', name: 'Shoulder Bag', category: 'bags', price: 49.99, compare: null, image: assets[4], rating: 4.6, reviews: 60, description: 'A compact shoulder bag with a wide strap and enough room for the essentials.' },
  { id: 'scented-candle', slug: 'scented-candle', name: 'Scented Candle', category: 'beauty', price: 19.99, compare: null, image: assets[7], rating: 4.8, reviews: 40, description: 'A quiet, woody candle for the softer moments at home.' },
  { id: 'soft-tailored-blazer', slug: 'soft-tailored-blazer', name: 'Soft Tailored Blazer', category: 'clothing', price: 89.99, compare: 109.99, image: assets[10], rating: 4.8, reviews: 42, onSale: true, description: 'A softly tailored blazer with a clean shoulder and an easy, unlined feel.' },
  { id: 'leather-crossbody', slug: 'leather-crossbody', name: 'Leather Crossbody', category: 'bags', price: 74.99, compare: null, image: assets[15], rating: 4.7, reviews: 51, description: 'A refined crossbody with considered pockets and a comfortable adjustable strap.' },
  { id: 'everyday-loafer', slug: 'everyday-loafer', name: 'Everyday Loafer', category: 'shoes', price: 79.99, compare: null, image: assets[8], rating: 4.6, reviews: 63, description: 'A polished loafer with a cushioned footbed for long, easy days.' },
  { id: 'golden-hoop-earrings', slug: 'golden-hoop-earrings', name: 'Golden Hoop Earrings', category: 'accessories', price: 26.99, compare: null, image: assets[12], rating: 4.8, reviews: 38, description: 'Slim, lightweight hoops with a softly polished finish.' },
  { id: 'summer-cotton-dress', slug: 'summer-cotton-dress', name: 'Summer Cotton Dress', category: 'clothing', price: 64.99, compare: null, image: assets[11], rating: 4.7, reviews: 28, description: 'An airy cotton dress with a relaxed waist and effortless movement.' },
  { id: 'woven-sun-hat', slug: 'woven-sun-hat', name: 'Woven Sun Hat', category: 'hats', price: 32.99, compare: null, image: assets[9], rating: 4.6, reviews: 22, description: 'A softly structured woven hat for bright days and long walks.' },
  { id: 'daily-tank', slug: 'daily-tank', name: 'Daily Tank', category: 'clothing', price: 24.99, compare: null, image: assets[19], rating: 4.5, reviews: 31, description: 'A close but comfortable everyday layer cut from soft cotton jersey.' }
];

const extraNames = [
  'Relaxed Cotton Tee', 'Tailored Wide Leg Trouser', 'Soft Rib Tank', 'Fine Merino Pullover', 'Boxy Denim Jacket', 'Everyday Linen Pant',
  'Canvas Market Tote', 'Structured Mini Bag', 'Soft Hobo Bag', 'Slim Leather Belt', 'Textured Shoulder Bag',
  'Canvas Slip-On', 'Quiet Runner Sneaker', 'Soft Leather Sandal', 'Minimal Mule',
  'Slim Watch', 'Silk Scarf', 'Sculptural Hair Clip', 'Everyday Studs', 'Pearl Drop Earrings',
  'Barrier Cream', 'Everyday Hand Balm', 'Soft Cleansing Oil', 'Quiet Room Spray', 'Nourishing Lip Oil',
  'Washed Cotton Cap', 'Wool Blend Beanie', 'Linen Bucket Hat'
];
const extraCategories = ['clothing', 'clothing', 'clothing', 'clothing', 'clothing', 'clothing', 'bags', 'bags', 'bags', 'accessories', 'bags', 'shoes', 'shoes', 'shoes', 'shoes', 'accessories', 'accessories', 'accessories', 'accessories', 'accessories', 'beauty', 'beauty', 'beauty', 'beauty', 'beauty', 'hats', 'hats', 'hats'];
const generatedProducts = Array.from({ length: 100 }, (_, index) => {
  const nameIndex = index % extraNames.length;
  const name = `${extraNames[nameIndex]} ${Math.floor(index / extraNames.length) + 1}`;
  const category = extraCategories[nameIndex];
  const price = Number((18 + ((index * 13) % 83) + .99).toFixed(2));
  return {
    id: `sample-${index + 1}`,
    slug: `sample-${index + 1}-${extraNames[nameIndex].toLowerCase().replace(/[^a-z]+/g, '-')}`,
    name,
    category,
    price,
    compare: index % 7 === 0 ? Number((price + 15).toFixed(2)) : null,
    image: assets[(index + 4) % assets.length],
    rating: Number((4.3 + ((index % 6) * .1)).toFixed(1)),
    reviews: 12 + (index * 17) % 146,
    newArrival: index % 3 === 0,
    onSale: index % 7 === 0,
    description: 'A considered Lunara essential with an easy silhouette, quiet details and everyday versatility.'
  };
});
const products = [...seedProducts, ...generatedProducts];

const storedCart = (() => { try { return JSON.parse(localStorage.getItem('lunara-cart') || '[]'); } catch { return []; } })();
const storedWishlist = (() => { try { return JSON.parse(localStorage.getItem('lunara-wishlist') || '[]'); } catch { return []; } })();
const state = { cart: Array.isArray(storedCart) ? storedCart : [], wishlist: Array.isArray(storedWishlist) ? storedWishlist : [], mobileNav: false, filterOpen: false, heroSlide: 0, quantity: 1 };

function money(value) { return `$${Number(value).toFixed(2)}`; }
function getProduct(slug) { return products.find((product) => product.slug === slug) || products[0]; }
function cartCount() { return state.cart.reduce((total, item) => total + item.qty, 0); }
function cartSubtotal() { return state.cart.reduce((total, item) => total + item.qty * item.price, 0); }
function saveState() {
  try { localStorage.setItem('lunara-cart', JSON.stringify(state.cart)); localStorage.setItem('lunara-wishlist', JSON.stringify(state.wishlist)); } catch { /* storage is optional for this demo */ }
}
function showToast(message) {
  const toast = document.querySelector('#toast');
  if (!toast) return;
  toast.textContent = message;
  toast.classList.add('is-visible');
  clearTimeout(showToast.timer);
  showToast.timer = setTimeout(() => toast.classList.remove('is-visible'), 2400);
}
function addToCart(product, qty = 1) {
  const found = state.cart.find((item) => item.id === product.id);
  if (found) found.qty += qty;
  else state.cart.push({ id: product.id, name: product.name, price: product.price, image: product.image, qty });
  saveState();
}
function toggleWishlist(product) {
  const index = state.wishlist.indexOf(product.id);
  if (index >= 0) state.wishlist.splice(index, 1);
  else state.wishlist.push(product.id);
  saveState();
}
function isWishlisted(product) { return state.wishlist.includes(product.id); }
function navigate(url) {
  const target = url || '/';
  window.history.pushState({}, '', target);
  state.mobileNav = false;
  state.filterOpen = false;
  render();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function renderHeader() {
  const path = window.location.pathname;
  const nav = [
    ['/','Home'], ['/shop','Shop'], ['/categories','Categories'], ['/new-arrivals','New Arrivals'], ['/deals','Deals'], ['/blog','Blog']
  ];
  return `<div class="announcement"><div class="announcement__message">${icon('truck')}<span>Free shipping on orders over $50!</span></div><div class="announcement__links"><a href="/about">About Us</a><a href="/contact">Contact</a><a href="/faq">FAQ</a><span>🇺🇸&nbsp; US ($) ${icon('chevron')}</span></div></div>
  <header class="site-header"><div class="main-nav"><button class="icon-button mobile-menu" data-mobile-menu aria-label="Open menu">${icon('menu')}</button><a class="logo" href="/">LUNARA<small>SHOP</small></a><nav class="nav-links" aria-label="Main navigation">${nav.map(([href, label]) => `<a class="nav-link ${path === href || (href !== '/' && path.startsWith(href)) ? 'active' : ''}" href="${href}">${label}${['/shop','/categories'].includes(href) ? icon('chevron') : ''}</a>`).join('')}</nav><div class="header-tools"><form class="search-box" data-search-form><input name="q" aria-label="Search products" placeholder="Search products..." autocomplete="off" /><button class="icon-button" aria-label="Search" type="submit">${icon('search')}</button></form><button class="icon-button mobile-search" data-mobile-search aria-label="Search">${icon('search')}</button><a class="icon-button" href="/account" aria-label="Account">${icon('user')}</a><a class="icon-button" href="/wishlist" aria-label="Wishlist">${icon('heart')}<span class="badge">${state.wishlist.length}</span></a><button class="icon-button" data-open-cart aria-label="Cart">${icon('cart')}<span class="badge">${cartCount()}</span></button></div></div>${state.mobileNav ? `<div class="mobile-nav"><div class="mobile-nav__head"><span>Menu</span><button class="icon-button" data-mobile-menu aria-label="Close menu">${icon('close')}</button></div>${nav.map(([href, label]) => `<a href="${href}">${label}</a>`).join('')}<hr/><a href="/about">About Us</a><a href="/contact">Contact</a><a href="/faq">FAQ</a></div>` : ''}</header>`;
}

function renderBenefits(compact = false) {
  const items = [['truck','Free Shipping','On orders over $50'], ['shield','Secure Payment','100% secure payment'], ['return','Easy Returns','30-day return policy'], ['headset','24/7 Support','We’re here to help']];
  return `<div class="${compact ? 'brand-benefits' : 'benefit-row'}"><div class="container benefits">${items.map(([ico, title, copy]) => `<div class="benefit"><div class="benefit__icon">${icon(ico)}</div><div><strong>${title}</strong><span>${copy}</span></div></div>`).join('')}</div></div>`;
}

function renderFooter() {
  const columns = [
    ['Shop', [['/shop','All Products'],['/category/clothing','Clothing'],['/category/bags','Bags'],['/category/shoes','Shoes'],['/category/accessories','Accessories'],['/category/beauty','Beauty']]],
    ['Customer Care', [['/contact','Contact Us'],['/faq','FAQ'],['/shipping','Shipping & Delivery'],['/returns','Returns & Refunds'],['/size-guide','Size Guide']]],
    ['Company', [['/about','About Us'],['/about#story','Our Story'],['/sustainability','Sustainability'],['/contact','Careers'],['/contact','Press']]],
    ['Legal', [['/terms','Terms of Service'],['/privacy-policy','Privacy Policy'],['/privacy-policy','Cookie Policy']]]
  ];
  return `<footer class="site-footer"><div class="container"><div class="footer-grid"><div class="footer-brand"><a class="logo" href="/">LUNARA<small>SHOP</small></a><p>Timeless pieces, thoughtfully designed for a simpler, more beautiful life.</p><div class="footer-socials">${icon('facebook')}${icon('instagram')}${icon('linkedin')}<span style="font-weight:700;font-size:12px">t</span></div></div>${columns.map(([title, links]) => `<div class="footer-column"><h3>${title}</h3>${links.map(([href,label]) => `<a href="${href}">${label}</a>`).join('')}</div>`).join('')}</div><div class="footer-bottom"><span>© 2024 Lunara Shop. All Rights Reserved.</span><div class="payments"><span class="payment">VISA</span><span class="payment">MC</span><span class="payment">Apple Pay</span><span class="payment">Pay</span><span class="payment">AMEX</span></div></div></div></footer>`;
}

function renderHero() {
  const slides = [
    ['NEW COLLECTION','Simplicity<br/>That Inspires','Elevate your everyday with timeless pieces made for comfort, quality and confidence.'],
    ['THE LUNARA EDIT','Quietly<br/>Beautiful','Thoughtful layers and small details for the days you want to feel most like yourself.'],
    ['SPRING / SUMMER','Made for<br/>Everyday','Easy silhouettes, warm neutrals and considered essentials to carry you through the season.']
  ];
  const slide = slides[state.heroSlide];
  return `<section class="hero"><div class="container hero__inner"><div class="hero__copy"><p class="eyebrow">${slide[0]}</p><h1>${slide[1]}</h1><p>${slide[2]}</p><a class="btn" href="/shop">Shop Now ${icon('arrow')}</a><div class="hero__controls">${slides.map((_, i) => `<button class="${i === state.heroSlide ? 'active' : ''}" data-hero-slide="${i}" aria-label="Slide ${i + 1}"></button>`).join('')}</div></div></div></section>`;
}

function renderCategoryCard(category) {
  return `<a class="category-card" href="/category/${category.slug}"><div class="category-card__image"><img src="${category.image}" alt="${category.name}" loading="lazy" /></div><div class="category-card__copy"><h3>${category.name}</h3><span>Shop now ${icon('arrow')}</span></div></a>`;
}

function renderRating(product) {
  const rounded = Math.round(product.rating);
  return `<div class="rating" aria-label="${product.rating} out of 5 stars">${'★'.repeat(rounded)}${'☆'.repeat(5 - rounded)} <span>(${product.reviews})</span></div>`;
}

function renderProductCard(product, options = {}) {
  const wishlist = isWishlisted(product);
  return `<article class="product-card"><div class="product-card__media"><a href="/product/${product.slug}"><img src="${product.image}" alt="${product.name}" loading="lazy" /></a><button class="product-card__favorite ${wishlist ? 'is-active' : ''}" data-wishlist="${product.id}" aria-label="${wishlist ? 'Remove from wishlist' : 'Add to wishlist'}">${icon('heart')}</button></div><a href="/product/${product.slug}"><h3>${product.name}</h3></a><div class="price"><strong>${money(product.price)}</strong>${product.compare ? `<span class="compare">${money(product.compare)}</span>` : ''}</div>${renderRating(product)}${options.noCart ? '' : `<button class="card-cart" data-add="${product.id}">${icon('cart')} &nbsp; Add to Cart</button>`}</article>`;
}

function renderHome() {
  const arrivals = seedProducts.slice(0, 5);
  const gallery = [assets[7], assets[0], assets[1], assets[23], assets[10], assets[5]];
  return `${renderHero()}${renderBenefits()}<main><section class="section container"><div class="section-head"><h2 class="section-title">Shop By Category</h2><a class="section-link" href="/categories">Browse all categories ${icon('arrow')}</a></div><div class="category-grid">${categoryData.map(renderCategoryCard).join('')}</div></section><section class="section container" style="padding-top:0"><div class="section-head"><h2 class="section-title">New Arrivals</h2><a class="section-link" href="/new-arrivals">View all ${icon('arrow')}</a></div><div class="product-grid">${arrivals.map((product) => renderProductCard(product)).join('')}</div></section><section class="section container" style="padding-top:19px"><div class="promo-grid"><div class="promo promo--sale"><div class="promo__copy"><p class="eyebrow">Summer Sale</p><h3>Up to 30% Off</h3><p>Limited time offer on selected items.</p><a class="btn" href="/deals">Shop Sale ${icon('arrow')}</a></div></div><div class="promo promo--new"><div class="promo__copy"><p class="eyebrow">New Season</p><h3>Fresh Styles Added</h3><p>Explore the latest trends just for you.</p><a class="btn" href="/new-arrivals">Shop New In ${icon('arrow')}</a></div></div></div></section><section class="container brand-benefits"><div class="benefits"><div class="benefit"><div class="benefit__icon">${icon('leaf')}</div><div><strong>Quality Materials</strong><span>Carefully selected for durability and comfort.</span></div></div><div class="benefit"><div class="benefit__icon">${icon('tag') || icon('spark')}</div><div><strong>Great Prices</strong><span>Affordable styles for every budget.</span></div></div><div class="benefit"><div class="benefit__icon">${icon('userGroup')}</div><div><strong>Trusted by Customers</strong><span>Thoughtful products, carefully packed.</span></div></div><div class="benefit"><div class="benefit__icon">${icon('globe')}</div><div><strong>Sustainable Choice</strong><span>Better for you & the planet.</span></div></div></div></section><section class="section social-section container"><div class="section-head"><h2 class="section-title" style="font-size:15px;font-family:var(--sans);font-weight:600">Follow us @Lunara.Shop</h2><span class="section-link">View on Instagram ${icon('arrow')}</span></div><div class="social-grid">${gallery.map((image, i) => `<div class="social-tile"><img src="${image}" alt="Lunara editorial moment ${i + 1}" loading="lazy" /></div>`).join('')}</div></section></main>`;
}

function renderPageHero(title, description, about = false) {
  return `<section class="${about ? 'about-hero' : 'page-hero'}"><div class="container page-hero__inner"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<span>${title}</span></div><div class="${about ? 'about-hero__copy' : ''}"><h1>${title}</h1><p>${description}</p>${about ? `<a class="btn" href="/shop" style="margin-top:20px">Our Collection ${icon('arrow')}</a>` : ''}</div></div></section>`;
}

function renderFilters(params) {
  const activeCategory = params.get('category') || '';
  const countFor = (slug) => products.filter((product) => product.category === slug).length;
  return `<aside class="filters ${state.filterOpen ? 'is-open' : ''}"><h2 class="filter-heading">Categories</h2><div class="filter-group"><div class="filter-list"><a class="${!activeCategory ? 'active' : ''}" href="/shop">All Products <span>(${products.length})</span></a>${categoryData.map((category) => `<a class="${activeCategory === category.slug ? 'active' : ''}" href="/shop?category=${category.slug}">${category.name} <span>(${countFor(category.slug)})</span></a>`).join('')}</div></div><div class="filter-group"><h3>Filter By</h3><h4 style="font-size:12px;font-weight:500;margin:0">Price</h4><div class="range"><input type="range" min="0" max="200" value="200" aria-label="Maximum price" /><div class="range__labels"><span>$0</span><span>$200</span></div></div></div><div class="filter-group"><h3>Color</h3><div class="swatches"><button class="swatch active" style="background:#f3f1ec" aria-label="Ivory"></button><button class="swatch" style="background:#ddc5a7" aria-label="Sand"></button><button class="swatch" style="background:#a58c77" aria-label="Taupe"></button><button class="swatch" style="background:#151515" aria-label="Black"></button><button class="swatch" style="background:#68715b" aria-label="Olive"></button></div></div><div class="filter-group"><h3>Size</h3><div class="sizes">${['XS','S','M','L','XL'].map((size, i) => `<label class="check-row"><input type="checkbox" ${i === 2 ? 'checked' : ''} />${size}<span style="margin-left:auto;color:var(--muted);font-size:10px">(${12 + i * 8})</span></label>`).join('')}</div></div><div class="filter-group"><h3>Rating</h3><div class="stars-filter">${[5,4,3,2,1].map((rating, i) => `<label><span>${'★'.repeat(rating)}${'☆'.repeat(5 - rating)}</span><em style="font-style:normal;color:var(--muted)">(${48 - i * 12}) & up</em></label>`).join('')}</div></div><div class="filter-group"><h3>Availability</h3><div class="sizes"><label class="check-row"><input type="checkbox" checked />In Stock <span style="margin-left:auto;color:var(--muted);font-size:10px">(${products.length - 6})</span></label><label class="check-row"><input type="checkbox" />Out of Stock <span style="margin-left:auto;color:var(--muted);font-size:10px">(6)</span></label></div></div></aside>`;
}

function getCatalogProducts(params) {
  const query = (params.get('q') || '').trim().toLowerCase();
  const category = params.get('category') || '';
  const saleOnly = window.location.pathname === '/deals';
  const newOnly = window.location.pathname === '/new-arrivals';
  let list = products.filter((product) => (!category || product.category === category) && (!query || `${product.name} ${product.category}`.toLowerCase().includes(query)) && (!saleOnly || product.onSale) && (!newOnly || product.newArrival));
  const sort = params.get('sort') || 'featured';
  if (sort === 'price-asc') list = list.sort((a,b) => a.price - b.price);
  if (sort === 'price-desc') list = list.sort((a,b) => b.price - a.price);
  if (sort === 'rating') list = list.sort((a,b) => b.rating - a.rating);
  if (sort === 'newest') list = list.sort((a,b) => Number(b.newArrival) - Number(a.newArrival));
  const page = Math.max(1, Number(params.get('page') || 1));
  const pageSize = 12;
  return { list, page, pageSize, visible: list.slice((page - 1) * pageSize, page * pageSize), sort, query, category };
}

function renderCatalog(forcedCategory = '') {
  const params = new URLSearchParams(window.location.search);
  if (forcedCategory) params.set('category', forcedCategory);
  const catalog = getCatalogProducts(params);
  const isSearch = window.location.pathname === '/search';
  const heading = isSearch ? 'Search results' : window.location.pathname === '/new-arrivals' ? 'New Arrivals' : window.location.pathname === '/deals' ? 'Deals' : 'Shop';
  const description = isSearch ? `Showing results for “${catalog.query || 'all products'}”.` : 'Discover our latest collections and find pieces that inspire your everyday life.';
  const totalPages = Math.max(1, Math.ceil(catalog.list.length / catalog.pageSize));
  const start = catalog.list.length ? (catalog.page - 1) * catalog.pageSize + 1 : 0;
  const end = Math.min(catalog.page * catalog.pageSize, catalog.list.length);
  const querySuffix = (page) => { const next = new URLSearchParams(params); next.set('page', page); return `${window.location.pathname}?${next.toString()}`; };
  return `${renderPageHero(heading, description)}<main class="container shop-layout"><button class="btn btn--ghost filter-mobile-toggle" data-filter-toggle>${icon('menu')} Filters</button>${renderFilters(params)}<section class="catalog"><div class="catalog__top"><p class="results-count">Showing ${start}–${end} of ${catalog.list.length} results</p><select class="sort" data-sort aria-label="Sort products"><option value="featured" ${catalog.sort === 'featured' ? 'selected' : ''}>Sort by: Featured</option><option value="newest" ${catalog.sort === 'newest' ? 'selected' : ''}>Newest</option><option value="price-asc" ${catalog.sort === 'price-asc' ? 'selected' : ''}>Price: Low to High</option><option value="price-desc" ${catalog.sort === 'price-desc' ? 'selected' : ''}>Price: High to Low</option><option value="rating" ${catalog.sort === 'rating' ? 'selected' : ''}>Highest Rated</option></select></div>${catalog.visible.length ? `<div class="catalog-grid">${catalog.visible.map((product) => renderProductCard(product)).join('')}</div>` : `<div class="empty-state"><div>${icon('search')}</div><h2>No pieces found</h2><p>Try a different search or explore the full collection.</p><a class="btn" href="/shop">View all products</a></div>`}<div class="pagination"><a class="page-button arrow" href="${querySuffix(Math.max(1, catalog.page - 1))}" aria-label="Previous page">${icon('chevronLeft')}</a>${Array.from({length: Math.min(totalPages, 5)}, (_, i) => i + 1).map((page) => `<a class="page-button ${catalog.page === page ? 'active' : ''}" href="${querySuffix(page)}">${page}</a>`).join('')}${totalPages > 5 ? '<span>...</span><span class="page-button">' + totalPages + '</span>' : ''}<a class="page-button arrow" href="${querySuffix(Math.min(totalPages, catalog.page + 1))}" aria-label="Next page">${icon('chevronRight')}</a></div></section></main>${renderBenefits(true)}`;
}

function renderAbout() {
  return `${renderPageHero('About Lunara', 'At Lunara, we believe that simplicity is the ultimate sophistication. Our collections are thoughtfully curated to bring you timeless pieces that elevate your everyday life.', true)}<main><section class="container mission"><h2>Our Mission</h2><p>We’re here to help you feel confident and comfortable in what you wear.<br/>Every piece is designed with quality, crafted with care, and chosen to last.</p><div class="values"><div class="value">${icon('leaf')}<strong>Timeless Design</strong><p>Elegant, minimal pieces that never go out of style.</p></div><div class="value">${icon('spark')}<strong>Quality First</strong><p>We use high-quality materials for lasting comfort.</p></div><div class="value">${icon('heart')}<strong>Made for You</strong><p>Designed to fit your lifestyle and make you feel your best.</p></div><div class="value">${icon('globe')}<strong>Sustainable Choice</strong><p>We’re committed to ethical and sustainable practices.</p></div></div></section><section class="container"><div class="story" id="story"><div class="story__image"></div><div class="story__copy"><p class="eyebrow">Our Story</p><h2>Simplicity That Inspires</h2><p>Lunara was born from a love for minimalist fashion and a desire to create pieces that make everyday moments feel special.</p><p>From the fabrics we choose to the details we design, everything we do is guided by our passion for quality, simplicity, and you.</p><a class="btn" href="/shop">Learn More ${icon('arrow')}</a></div></div></section><section class="container why"><h2>Why Shop With Us</h2>${renderBenefits(true)}</section><section class="container team-section"><div class="team-section__inner"><h2>Meet The Team</h2><div class="team-grid">${[['Emma Johnson','Founder & CEO',assets[21]],['Sophia Lee','Head of Design',assets[20]],['Liam Carter','Operations Manager',assets[18]],['Olivia Martin','Customer Experience',assets[16]]].map(([name, role, image]) => `<article class="team-card"><img src="${image}" alt="${name}, sample team profile" loading="lazy"/><div class="team-card__copy"><strong>${name}</strong><span>${role}</span><div class="team-socials">${icon('facebook')}${icon('instagram')}${icon('linkedin')}</div></div></article>`).join('')}</div></div></section><section class="container"><div class="newsletter"><div class="newsletter__icon">${icon('mail')}</div><div class="newsletter__copy"><h2>Stay in the Loop</h2><p>Sign up and get 10% off your first order.<br/>Plus, be the first to know about new arrivals and exclusive offers.</p></div><form class="newsletter__form" data-newsletter><input type="email" name="email" placeholder="Enter your email" aria-label="Email address" required/><button class="btn" type="submit">Subscribe</button></form></div></section></main>`;
}

function renderProductDetail(product) {
  const detailImages = [product.image, assets[(products.indexOf(product) + 3) % assets.length], assets[(products.indexOf(product) + 8) % assets.length], assets[(products.indexOf(product) + 12) % assets.length]];
  return `<main class="container product-detail"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<a href="/shop">Shop</a>${icon('chevronRight')}<span>${product.name}</span></div><div class="product-detail__layout"><div class="product-detail__gallery"><div class="gallery-thumbs">${detailImages.map((image, i) => `<button class="gallery-thumb ${i === 0 ? 'active' : ''}" data-gallery-image="${image}"><img src="${image}" alt="${product.name} view ${i + 1}"/></button>`).join('')}</div><div class="gallery-main"><img id="gallery-main-image" src="${product.image}" alt="${product.name}"/></div></div><section class="product-detail__info"><p class="eyebrow">${categoryData.find((category) => category.slug === product.category)?.name || 'Lunara collection'}</p><h1>${product.name}</h1><div class="rating">${'★'.repeat(Math.round(product.rating))}${'☆'.repeat(5 - Math.round(product.rating))}<span>(${product.reviews} reviews)</span></div><div class="detail-price"><strong>${money(product.price)}</strong>${product.compare ? `<span class="compare">${money(product.compare)}</span>` : ''}</div><p class="detail-copy">${product.description}</p><hr class="detail-rule"/><div class="option-label"><span>Color: <strong>Warm Taupe</strong></span></div><div class="detail-swatches"><button class="swatch active" style="background:#a58c77" aria-label="Warm Taupe"></button><button class="swatch" style="background:#eee8dc" aria-label="Ivory"></button><button class="swatch" style="background:#1d1d1d" aria-label="Black"></button></div><div class="option-label"><span>Size</span><a href="/size-guide">Size Guide</a></div><div class="size-buttons">${['XS','S','M','L','XL'].map((size, i) => `<button class="size-button ${i === 2 ? 'active' : ''}">${size}</button>`).join('')}</div><div class="purchase-row"><div class="quantity"><button data-detail-qty="-1">−</button><span id="detail-qty">1</span><button data-detail-qty="1">+</button></div><button class="btn" data-add-detail="${product.id}">${icon('cart')} Add to Cart</button><button class="icon-button" data-wishlist="${product.id}" aria-label="Add to wishlist">${icon('heart')}</button></div><div class="detail-feature-list"><div class="detail-feature">${icon('truck')} Free shipping on orders over $50</div><div class="detail-feature">${icon('return')} 30-day easy returns</div><div class="detail-feature">${icon('shield')} Secure checkout and careful packaging</div></div></section></div></main>`;
}

function renderCartPage() {
  if (!state.cart.length) return `<main class="container cart-page"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<span>Cart</span></div><div class="empty-state"><div>${icon('cart')}</div><h2>Your cart is waiting</h2><p>Discover something considered for your everyday.</p><a class="btn" href="/shop">Continue Shopping ${icon('arrow')}</a></div></main>`;
  return `<main class="container cart-page"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<span>Cart</span></div><div class="section-head"><h1 class="section-title">Your Cart</h1><span class="results-count">${cartCount()} items</span></div><div class="cart-layout"><div class="cart-table">${state.cart.map((item) => `<div class="cart-row"><img src="${item.image}" alt="${item.name}"/><div><h3>${item.name}</h3><p>Warm Taupe · One size</p></div><div class="cart-quantity"><button data-cart-qty="-1" data-id="${item.id}">−</button><span>${item.qty}</span><button data-cart-qty="1" data-id="${item.id}">+</button></div><strong>${money(item.qty * item.price)}</strong><button class="cart-remove" data-remove-cart="${item.id}">Remove</button></div>`).join('')}</div><aside class="cart-summary"><h2>Order Summary</h2><p class="summary-line"><span>Subtotal</span><strong>${money(cartSubtotal())}</strong></p><p class="summary-line"><span>Shipping</span><span>${cartSubtotal() >= 50 ? 'Free' : '$5.00'}</span></p><p class="summary-line summary-total"><span>Total</span><strong>${money(cartSubtotal() + (cartSubtotal() >= 50 ? 0 : 5))}</strong></p><button class="btn" data-checkout>Proceed to Checkout ${icon('arrow')}</button><a class="section-link" style="justify-content:center;margin-top:14px" href="/shop">Continue Shopping</a></aside></div></main>`;
}

function renderDrawer() {
  return `<div class="modal-backdrop" data-close-cart></div><aside class="drawer" data-cart-drawer><div class="drawer__head"><h2>Your Cart <span style="font-family:var(--sans);font-size:11px;color:var(--muted)">(${cartCount()})</span></h2><button class="drawer__close" data-close-cart aria-label="Close cart">${icon('close')}</button></div><div class="drawer__items">${state.cart.length ? state.cart.map((item) => `<div class="drawer-item"><img src="${item.image}" alt="${item.name}"/><div><h3>${item.name}</h3><p>${item.qty} × ${money(item.price)}</p></div><button data-remove-cart="${item.id}" aria-label="Remove ${item.name}">${icon('close')}</button></div>`).join('') : `<div class="empty-state"><div>${icon('cart')}</div><h2>Your cart is empty</h2><p>Add a few considered essentials.</p></div>`}</div>${state.cart.length ? `<div class="drawer__bottom"><p class="summary-line"><span>Subtotal</span><strong>${money(cartSubtotal())}</strong></p><a href="/cart" class="btn">View Cart & Checkout ${icon('arrow')}</a></div>` : ''}</aside>`;
}

function renderWishlist() {
  const items = products.filter((product) => state.wishlist.includes(product.id));
  return `<main class="container cart-page"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<span>Wishlist</span></div><div class="section-head"><h1 class="section-title">Your Wishlist</h1><span class="results-count">${items.length} saved</span></div>${items.length ? `<div class="product-grid">${items.map((product) => renderProductCard(product)).join('')}</div>` : `<div class="empty-state"><div>${icon('heart')}</div><h2>Save what inspires you</h2><p>Tap the heart on any piece to keep it close.</p><a class="btn" href="/shop">Explore the Collection ${icon('arrow')}</a></div>`}</main>`;
}

function renderSimplePage(title, copy) {
  return `<main class="container cart-page"><div class="breadcrumb"><a href="/">Home</a>${icon('chevronRight')}<span>${title}</span></div><div class="empty-state" style="padding-top:25px"><h2>${title}</h2><p style="max-width:500px;margin:0 auto 22px">${copy}</p><a class="btn" href="/shop">Shop the Collection ${icon('arrow')}</a></div></main>`;
}

function render() {
  const path = window.location.pathname.replace(/\/$/, '') || '/';
  let page = '';
  if (path === '/' || path === '/index.html') page = renderHome();
  else if (path === '/about') page = renderAbout();
  else if (path === '/cart') page = renderCartPage();
  else if (path === '/wishlist') page = renderWishlist();
  else if (path === '/shop' || path === '/categories' || path === '/search' || path === '/new-arrivals' || path === '/deals' || path.startsWith('/category/')) {
    const params = new URLSearchParams(window.location.search);
    if (path.startsWith('/category/')) params.set('category', path.split('/')[2]);
    page = renderCatalog(path.startsWith('/category/') ? path.split('/')[2] : '');
  } else if (path.startsWith('/product/')) page = renderProductDetail(getProduct(path.split('/')[2]));
  else if (path === '/contact') page = renderSimplePage('Contact Us', 'Our care team is here to help with orders, sizing, shipping and anything else you are considering. Send us a note and we will reply within one business day.');
  else if (path === '/faq') page = renderSimplePage('Frequently Asked Questions', 'Find answers about delivery, returns, sizing and caring for your Lunara pieces.');
  else if (path === '/account' || path === '/login') page = renderSimplePage('Welcome back', 'Account sign-in is ready for the customer account service. Continue browsing while you get set up.');
  else page = renderSimplePage('Lunara Shop', 'Thoughtful essentials for everyday living.');
  document.querySelector('#app').innerHTML = `${renderHeader()}${page}${renderFooter()}${renderDrawer()}`;
  bindEvents();
}

function bindEvents() {
  document.querySelectorAll('a[href^="/"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const href = link.getAttribute('href');
      if (!href || href.startsWith('/#')) return;
      event.preventDefault();
      navigate(href);
    });
  });
  document.querySelectorAll('[data-add]').forEach((button) => button.addEventListener('click', () => { const product = products.find((item) => item.id === button.dataset.add); addToCart(product); render(); showToast(`${product.name} added to your cart.`); }));
  document.querySelectorAll('[data-wishlist]').forEach((button) => button.addEventListener('click', () => { const product = products.find((item) => item.id === button.dataset.wishlist); toggleWishlist(product); render(); showToast(isWishlisted(product) ? `${product.name} saved to your wishlist.` : `${product.name} removed from your wishlist.`); }));
  document.querySelectorAll('[data-open-cart]').forEach((button) => button.addEventListener('click', () => { document.querySelector('[data-cart-drawer]')?.classList.add('is-open'); document.querySelector('.modal-backdrop')?.classList.add('is-open'); document.body.classList.add('drawer-open'); }));
  document.querySelectorAll('[data-close-cart]').forEach((button) => button.addEventListener('click', () => { document.querySelector('[data-cart-drawer]')?.classList.remove('is-open'); document.querySelector('.modal-backdrop')?.classList.remove('is-open'); document.body.classList.remove('drawer-open'); }));
  document.querySelectorAll('[data-remove-cart]').forEach((button) => button.addEventListener('click', () => { state.cart = state.cart.filter((item) => item.id !== button.dataset.removeCart); saveState(); render(); showToast('Item removed from your cart.'); }));
  document.querySelectorAll('[data-cart-qty]').forEach((button) => button.addEventListener('click', () => { const item = state.cart.find((entry) => entry.id === button.dataset.id); if (!item) return; item.qty = Math.max(1, item.qty + Number(button.dataset.cartQty)); saveState(); render(); }));
  document.querySelectorAll('[data-detail-qty]').forEach((button) => button.addEventListener('click', () => { state.quantity = Math.max(1, state.quantity + Number(button.dataset.detailQty)); const target = document.querySelector('#detail-qty'); if (target) target.textContent = state.quantity; }));
  document.querySelectorAll('[data-add-detail]').forEach((button) => button.addEventListener('click', () => { const product = products.find((item) => item.id === button.dataset.addDetail); addToCart(product, state.quantity); render(); showToast(`${product.name} added to your cart.`); state.quantity = 1; }));
  document.querySelectorAll('[data-gallery-image]').forEach((button) => button.addEventListener('click', () => { document.querySelector('#gallery-main-image').src = button.dataset.galleryImage; document.querySelectorAll('.gallery-thumb').forEach((thumb) => thumb.classList.remove('active')); button.classList.add('active'); }));
  document.querySelectorAll('[data-hero-slide]').forEach((button) => button.addEventListener('click', () => { state.heroSlide = Number(button.dataset.heroSlide); render(); }));
  document.querySelectorAll('[data-filter-toggle]').forEach((button) => button.addEventListener('click', () => { state.filterOpen = !state.filterOpen; render(); }));
  document.querySelectorAll('[data-sort]').forEach((select) => select.addEventListener('change', () => { const params = new URLSearchParams(window.location.search); params.set('sort', select.value); params.delete('page'); navigate(`${window.location.pathname}?${params.toString()}`); }));
  document.querySelectorAll('[data-mobile-menu]').forEach((button) => button.addEventListener('click', () => { state.mobileNav = !state.mobileNav; render(); }));
  document.querySelectorAll('[data-mobile-search]').forEach((button) => button.addEventListener('click', () => { const query = window.prompt('Search Lunara products'); if (query?.trim()) navigate(`/search?q=${encodeURIComponent(query.trim())}`); }));
  document.querySelectorAll('[data-search-form]').forEach((form) => form.addEventListener('submit', (event) => { event.preventDefault(); const query = new FormData(form).get('q'); navigate(`/search?q=${encodeURIComponent(String(query || '').trim())}`); }));
  document.querySelectorAll('[data-newsletter]').forEach((form) => form.addEventListener('submit', (event) => { event.preventDefault(); const email = new FormData(form).get('email'); if (email) { form.reset(); showToast('Thanks — you’re on the Lunara list.'); } }));
  document.querySelectorAll('[data-checkout]').forEach((button) => button.addEventListener('click', () => showToast('Checkout is ready for payment provider configuration.')));
}

window.addEventListener('popstate', render);
render();
