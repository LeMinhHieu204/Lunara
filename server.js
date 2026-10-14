const http = require('http');
const fs = require('fs');
const path = require('path');

const root = __dirname;
const port = Number(process.env.PORT || 4173);
const mime = {
  '.html': 'text/html; charset=utf-8',
  '.js': 'text/javascript; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.svg': 'image/svg+xml',
  '.txt': 'text/plain; charset=utf-8'
};

http.createServer((request, response) => {
  const cleanPath = decodeURIComponent(request.url.split('?')[0]);
  const requested = cleanPath === '/' ? '/index.html' : cleanPath;
  const filePath = path.join(root, requested);
  const safePath = filePath.startsWith(root) ? filePath : path.join(root, 'index.html');

  fs.readFile(safePath, (error, content) => {
    if (!error) {
      response.writeHead(200, { 'Content-Type': mime[path.extname(safePath)] || 'application/octet-stream' });
      response.end(content);
      return;
    }
    fs.readFile(path.join(root, 'index.html'), (fallbackError, fallback) => {
      response.writeHead(fallbackError ? 404 : 200, { 'Content-Type': 'text/html; charset=utf-8' });
      response.end(fallbackError ? 'Not found' : fallback);
    });
  });
}).listen(port, () => {
  console.log(`Lunara Shop running at http://localhost:${port}`);
});
