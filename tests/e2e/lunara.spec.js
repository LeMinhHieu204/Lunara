import { test, expect } from '@playwright/test';

const viewports = [
  ['375', { width: 375, height: 900 }],
  ['390', { width: 390, height: 900 }],
  ['768', { width: 768, height: 900 }],
  ['1024', { width: 1024, height: 900 }],
  ['1440', { width: 1440, height: 900 }]
];

test('reference pages render without horizontal overflow', async ({ page }) => {
  for (const [label, viewport] of viewports) {
    await page.setViewportSize(viewport);
    for (const route of ['/', '/shop', '/about', '/category/clothing', '/products/linen-oversize-shirt-001']) {
      await page.goto(route);
      await expect(page.locator('body')).toBeVisible();
      await page.evaluate(() => document.querySelectorAll('img[loading="lazy"]').forEach((image) => { image.loading = 'eager'; }));
      await page.waitForLoadState('networkidle');
      const brokenImages = await page.locator('img').evaluateAll((images) => images.filter((image) => !image.complete || image.naturalWidth === 0).map((image) => image.getAttribute('src')));
      expect(brokenImages).toEqual([]);
      if (route === '/about') await expect(page.getByRole('heading', { name: 'Meet The Team' })).toBeVisible();
      expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth + 1)).toBeTruthy();
      await page.screenshot({ path: `docs/screenshots/${label}-${route === '/' ? 'home' : route.slice(1).replaceAll('/', '-')}.png`, fullPage: true });
    }
  }
});

test('browse to product and add to cart', async ({ page }) => {
  await page.goto('/products/linen-oversize-shirt-001');
  await page.locator('.product-detail__info form[action*="/cart/items"] button[type="submit"]').click();
  await page.goto('/cart');
  await expect(page.getByText('Linen Oversize Shirt')).toBeVisible();
});

test('admin login reaches protected dashboard', async ({ page }) => {
  await page.goto('/login');
  await page.getByPlaceholder('Email address').fill('admin@lunara.test');
  await page.getByPlaceholder('Password').fill('password');
  await page.getByRole('button', { name: 'Sign In' }).click();
  await expect(page).toHaveURL(/\/account$/);
  await page.goto('/admin');
  await expect(page.getByRole('heading', { name: 'Admin Dashboard' })).toBeVisible();
  await page.goto('/admin/inventory');
    await expect(page.getByRole('heading', { name: 'Inventory' })).toBeVisible();
});
