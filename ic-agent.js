console.log('Script started');

const { Actor, HttpAgent } = require('@dfinity/agent');

console.log('Modules imported');

const canisterId = 'bd3sg-teaaa-aaaaa-qaaba-cai';
const agent = new HttpAgent({
    host: 'http://127.0.0.1:4943',
});

agent.fetchRootKey();

console.log('Agent created');

const idlFactory = ({ IDL }) => {
    const VoteActor = IDL.Service({
        vote: IDL.Func([], [], []),
    });
    return VoteActor;
};

console.log('IDL factory created');

const actor = Actor.createActor(idlFactory, { agent, canisterId });

console.log('Actor created');

exports.voteOnIC = async () => {
    console.log('voteOnIC called');
    try {
        const response = await actor.vote();
        console.log('Vote response', response);
    } catch (err) {
        console.log('Vote failed with error:', err.message);
        console.log('Stack trace:', err.stack);
        if (err.response) {
            console.log('Server response:', err.response);
        }
    }
};

console.log('voteOnIC defined');

exports.voteOnIC();
