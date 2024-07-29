import Principal "mo:base/Principal";
import Time "mo:base/Time";
import Nat64 "mo:base/Nat64";
import Debug "mo:base/Debug";
import Blob "mo:base/Blob";
import Int "mo:base/Int";
import Account "account";
import Text "mo:base/Text";
import Bool "mo:base/Bool";
import Array "mo:base/Array";
import Types "Types";

shared actor class Voting() = this {
    let tokenCanisterId : Text = "ryjl3-tyaaa-aaaaa-aaaba-cai";
    let burnAmount : Nat = 100000000;
    let platformAcc = Principal.fromText("rrkah-fqaaa-aaaaa-aaaaq-cai");
    let platformAccBlob = Account.accountIdentifier(platformAcc, Account.defaultSubaccount());
    Debug.print(debug_show(platformAccBlob));

    var voteDetails: [Types.VoteDetail] = [];

    public shared func vote(details: Text): async ?Nat64 {
        let token_canister_actor = actor (tokenCanisterId) : Types.TokenInterface;

        let fee: Nat = await token_canister_actor.icrc1_fee();

        let transaction: Types.TransferArgs = {
            memo = ?Blob.fromArray([]);
            from_subaccount = null;
            to = { owner = platformAcc; subaccount = null };
            amount = burnAmount;
            fee = ?fee;
            created_at_time = ?Nat64.fromNat(Int.abs(Time.now()));
        };

        let transferResult = await token_canister_actor.icrc1_transfer(transaction);

        Debug.print(debug_show (transferResult));

        switch (transferResult) {
            case (#Ok blockIndex) {
                Debug.print("Token burning successful");

                let newVoteDetail: Types.VoteDetail = {
                    details = details;
                    amount = burnAmount;
                    timestamp = Int.abs(Time.now());
                    blockIndex = Nat64.fromNat(blockIndex);
                };

                voteDetails := Array.append([newVoteDetail], voteDetails);
                Debug.print("Updated voteDetails: " # debug_show(voteDetails));

                return ?(Nat64.fromNat(blockIndex));
            };
            case (#Err err) {
                Debug.print(debug_show (err));
                return null;
            };
        };
    };

    public func icrc1_balance_of(tokenCanisterId : Text, account : Types.Account) : async Types.Balance {
        let token_canister_actor = actor (tokenCanisterId) : Types.TokenInterface;
        await token_canister_actor.icrc1_balance_of(account);
    };

    public func icrc1_metadata(tokenCanisterId : Text) : async Types.MetaData {
        let token_canister_actor = actor (tokenCanisterId) : Types.TokenInterface;
        await token_canister_actor.icrc1_metadata();
    };

    public func get_transactions(tokenCanisterId : Text, tnxDetails : Types.GetTransactionsRequest) : async Types.TransactionRange {
        let token_canister_actor = actor (tokenCanisterId) : Types.ArchiveInterface;
        await token_canister_actor.get_transactions(tnxDetails);
    };

    public func get_transaction(tokenCanisterId : Text, tnxIndex : Types.TxIndex) : async ?Types.Transaction {
        let token_canister_actor = actor (tokenCanisterId) : Types.ArchiveInterface;
        await token_canister_actor.get_transaction(tnxIndex);
    };

    public shared func total_transactions() : async Nat {
        let token_canister_actor = actor (tokenCanisterId) : Types.ArchiveInterface;
        return await token_canister_actor.total_transactions();
    };

    public shared (msg) func whoami() : async Text {
        Principal.toText(msg.caller);
    };


};
