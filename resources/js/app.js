console.log('app.js is loaded');

import { AuthClient } from '@dfinity/auth-client';
import { HttpAgent, Actor } from '@dfinity/agent';

console.log('AuthClient imported:', AuthClient);
console.log('HttpAgent imported:', HttpAgent);
console.log('Actor imported:', Actor);

let authClient;
let agentInitialized = new Promise((resolve, reject) => {
    AuthClient.create().then(async (client) => {
        authClient = client;
        window.AuthClient = authClient;

        const identity = authClient.getIdentity();
        const agent = new HttpAgent({ identity, host: 'http://127.0.0.1:4943' });

        await agent.fetchRootKey();

        window.authClient = authClient;
        window.agent = agent;
        window.Actor = Actor;

        console.log('AuthClient set on window:', window.authClient);
        console.log('HttpAgent set on window:', window.agent);
        console.log('Actor set on window:', window.Actor);

        resolve();
    }).catch((error) => {
        console.error('Error initializing AuthClient or HttpAgent:', error);
        reject(error);
    });
});

window.agentInitialized = agentInitialized;
