// SPDX-License-Identifier: MIT
pragma solidity ^0.8.7;

contract InvestmentFund {
    // using SafeMath for uint256;
    struct ShareHolder {
        uint256 Amount;
        string Klass;
        bool IsActive;
    }

    mapping(address => ShareHolder) private _shareholders;
    address internal investor;
    address internal coInvestor;
    uint256 public maxInvestable;

    event Deposited(address indexed payee, uint256 weiAmount);
    event Withdrawn(address indexed payee, uint256 weiAmount);
    event NewInvestor(address indexed invest, string klass, uint256 weiAmount);

    constructor() {
        investor = msg.sender; // contract creator is the investor
    }

    function setMaxInvestableByCoInvestor(uint256 amount) public {
        require(msg.sender==investor, "Investor Only");
        maxInvestable = amount;
    }

    function setCoInvestor(address nInvest) public {
        require(msg.sender==investor, "Investor Only");
        coInvestor = nInvest;
    }

    // Get Fund Balance
    function getBalance() view public  returns (uint256) {
        return address(this).balance;
    }

    function myBalance() view public returns (uint256) {
        address payee = msg.sender;
        // if (!_shareholders[payee].IsActive) {
        //     require(false, "You are not an investor");
        // }
        return _shareholders[payee].Amount;
    }

    function join() public payable {
        require(msg.value > 0, "Amount must not be zero");
        address payee = msg.sender;
        if (_shareholders[payee].IsActive) {
            require(false, "You are already investor");
        }

        _shareholders[payee] = ShareHolder({
            Amount: msg.value,
            Klass: "A",
            IsActive: true
        });
    }

    function deposit() public payable {
        // require(msg.value == amount, "Amount not available");
        require(msg.value > 0, "Amount must not be zero");
        address payee = msg.sender;
        uint amount = msg.value;

        if (!_shareholders[payee].IsActive) {
            require(false, "You are not investor");
        }

        _shareholders[payee].Amount = _shareholders[payee].Amount + amount;
        emit Deposited(payee, amount);
    }

    function invest(uint amount, address asset, string memory label) public {
    }

    function withdraw(uint amount, address addr) public {
        require(address(this).balance >= amount, "amount not available");
        // requires that its either the investor or the coInvestor requesting amount less set
        require(msg.sender == investor || (msg.sender==coInvestor&&amount<maxInvestable),
            "Must be investor or coInvestor");
        payable(addr).transfer(amount);
    }

}
