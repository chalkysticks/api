import express, { Request, Response, NextFunction } from 'express';
import morgan from 'morgan';
import { createProxyMiddleware } from 'http-proxy-middleware';

const app = express();
const port = 3000;


// Initialization
// ---------------------------------------------------------------------------

app.listen(port, () => {
    console.log(`Timezones by location application is running on port ${port}.`);
});


// Routes
// ---------------------------------------------------------------------------

app.get('/', (request: Request, response: Response, next: NextFunction) => {
    response.status(200).json({
        foo: 'bar',
    });
});

app.use('/v1/fact', createProxyMiddleware({
    target: 'http://localhost:7206',
    changeOrigin: true,
    pathRewrite: {
        [`^/v1/fact`]: '/fact',
    },
}));