<style type="text/css">
.loading-ind{
text-align: center;
    padding-top: 10px;
    height: 226px;
    position: absolute;
    z-index: 10000;
    background: rgba(255,255,255,.8);
    width: 100%;
    padding-top: 22px;
}
</style>
<div class="row" 
    style="background: #fff;padding: 10px;" 
	ng-controller="WalletCtrl">

    <div class="col-12"
        ng-init="loadWallet()">
    </div>

    <div class="col-12"
        style="text-align: center;border: 1px solid #ccc;padding-top: 100px;padding-bottom: 100px;">
        <div ng-if="!current_wallet && !loading">
            <img src="METAMASK.png" width="50px" />
            <h3>ETH SEPOLIA WALLET</h3>
            <p class="text-secondary"
                style="font-size:small">Crie uma carteira local conectada a testnet Ethereum Sepolia sem exposicao a internet.</p>
            <button class="btn btn-primary"
                ng-click="createWallet()"
                ng-disabled="loading">
                Criar Wallet
            </button>

            <button class="btn btn-primary"
                ng-disabled="loading">
                Importar Wallet
            </button>
        </div>

        <div ng-if="current_wallet">
            <h3>WALLET</h3>
            <p style="font-size:50px;margin:0px"> 
                <span class="text-secondary" style="">{{current_wallet.balance||'N/A'}}</span> 
                <span style="color:#333;font-weight: bold;">ETH</span>
            </p>
            <p class="text-secondary" style="margin: 0px;font-size: small">{{current_wallet.Address}}</p>
            <!--            <button class="btn btn-danger"
                ng-click="removeWallet()"
                ng-disabled="loading">
                Delete Wallet
            </button>-->        

            <button class="btn btn-primary"
                ng-if="!ContractFund"
                ng-click="LoadContract()"
                ng-disabled="loading">
                Open Fund
            </button>

            <div ng-if="ContractFund"
                style="margin-top: 15px;">
                <hr/>
                <h3>Investment Fund</h3>
                <p>Contract Address: <a href="{{'https://sepolia.etherscan.io/address/'+CT_ADDR}}">{{CT_ADDR}}</a></p>

                <div class="row rs-margin">
                    <div class="col-6">
                        <table class="table table-stripped"
                            >
                            <thead>
                                <tr>
                                    <td>Contract Funds</td>
                                    <td>My Balance</td>
                                    <td>Share %</td>
                                    <td>Your ID</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>{{contract_amount}} ETH</td>
                                    <td>{{my_balance||0}} ETH</td>
                                    <td>({{ (my_balance/contract_amount)*100 }}%)</td>
                                    <td>#{{ current_wallet.address.slice(0, 6) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <button class="btn btn-primary"
                            ng-click="loadContractDetails(ContractFund)"
                            ng-disabled="loading">
                            Refresh
                            <span class="fa fa-refresh"></span>
                        </button>
                    </div>

                    <div class="col-6">
                        <!-- <h3>Events</h3> -->
                        <table class="table table-stripped"
                            >
                            <thead>
                                <tr>
                                    <td>Event</td>
                                    <td>Amount</td>
                                    <td>Desc</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12" style="margin-top: 20px;"></div>

                    <div class="col-lg-4 col-md-6 col-xs-12 col-sm-12">
                        <div class="join-plugin text-left"
                            style="padding: 20px;border: 1px solid #ccc;box-shadow: 0px 0px 2px rgba(0,0,0,.3);">
                            <form name="ff1" ng-submit="JoinFund(ff1)">
                                <h3 style="margin: 0px;" class="text-danger">JOIN FUND</h3>
                                <p style="margin: 0px;font-size:small" class="text-secondary">In order to join the fund please input the amount you wish to start.</p>

                                <div ng-if="jerror" class="alert alert-danger" >
                                    <h4 style="margin:0px">Nao foi possivel concluir</h4>
                                    <p class="text-secondary"
                                        ng-repeat="e in jerror"
                                        style="margin:0px;font-size:small">
                                        {{e}}
                                    </p>
                                </div>

                                <div ng-if="jloading"
                                    class="loading-ind" 
                                    style="text-align: center;padding-top:10px">
                                    <h4>
                                        <span class="fa fa-refresh fa-spin text-danger"></span>
                                        Loading
                                    </h4>
                                </div>
                                <div ng-if="isJoined">
                                    <div class="alert alert-success">
                                        <h4 style="margin:0px;">WELCOME</h4>
                                        <p style="margin:0px;">You are joined</p>
                                    </div>
                                </div>

                                <div class="input-group" style="margin-top: 30px;"
                                    ng-if="!isJoined">
                                  <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Amount</span>
                                  <input type="number" class="form-control" aria-label="0" 
                                    ng-disabled="jloading"
                                    placeholder="000000000000 Wei" 
                                    required 
                                    ng-model="joinReq.amount" />
                                  <span class="input-group-addon"
                                    style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;background: gray;font-size: small;">Wei</span>
                                </div>
                                <p style="font-size:small"
                                    ng-if="!isJoined">
                                    <span style="color:#333">Min amount:</span> 
                                    <span style="font-weight: bold;">{{MIN_INVESTMENT_AMOUNT}} Wei</span>
                                    <span> | </span>
                                    <a href="javascript:void(0)" style="padding-left:8px"
                                       ng-click="joinReq.show_options = !joinReq.show_options">
                                        <u>More options</u>
                                    </a>
                                </p>

                                <div ng-if="joinReq.show_options && !isJoined">

                                    <div class="input-group" style="margin-top: 10px;">
                                      <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Max Gas</span>
                                      <input type="number" class="form-control" aria-label="0" 
                                        ng-disabled="xloading"
                                        placeholder="000000000000" 
                                        required 
                                        ng-model="joinReq.gas" />
                                    </div>

                                    <div class="input-group" style="margin-top: 10px;">
                                      <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Gas Price</span>
                                      <input type="text" class="form-control" aria-label="0" 
                                        ng-disabled="xloading"
                                        placeholder="000000000000 Wei" 
                                        required 
                                        ng-model="joinReq.gasPrice" />
                                      <span class="input-group-addon"
                                        style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;background: gray;font-size: small;">Wei</span>
                                    </div>

                                </div>


                                <div class="join-area text-center" style="margin-top:15px" 
                                    ng-if="!isJoined">
                                    <button class="btn btn-block btn-primary"
                                        type="submit" 
                                        ng-disabled="jloading">
                                        Join
                                    </button>
                                    <p style="font-size:x-small;" class="text-secondary">By joining you are to our <a href=""><u>terms of service</u></a></p>                          
                                </div>

                            </form>
                            
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-xs-12 col-sm-12">
                        <div class="deposit-plugin text-left"
                            style="padding: 20px;border: 1px solid #ccc;box-shadow: 0px 0px 2px rgba(0,0,0,.3);">
                            <form name="ff2" ng-submit="Deposit(ff2)">
                                <h3 style="margin: 0px;" class="text-danger">DEPOSIT ON FUND</h3>
                                <p style="margin: 0px;font-size:small" class="text-secondary">
                                    Deposit funds into the Investment Funds.
                                    Payouts are made every 100H or more 
                                </p>

                                <div ng-if="xerror" class="alert alert-danger" >
                                    <h4 style="margin:0px;font-size: 17px">Could not finish operation</h4>
                                    <p class="text-secondary"
                                        ng-repeat="e in xerror"
                                        style="margin:0px;font-size:small">
                                        {{e}}
                                    </p>
                                </div>

                                <div ng-if="xloading"
                                    class="loading-ind"
                                    style="text-align: center;padding-top:10px">
                                    <h4>
                                        <span class="fa fa-refresh fa-spin text-danger"></span>
                                        Loading
                                    </h4>
                                </div>
                                <div ng-if="hasDeposited">
                                    <div class="alert alert-success">
                                        <h4 style="margin:0px;font-size: 15px;font-weight: bold;">SUCCESSO</h4>
                                        <p style="margin:0px;font-size: small;color:#333;">Deposito de <strong>{{depositReq.amount}} WEI</strong> concluida com sucesso</p>
                                        <p style="margin:0px;font-size: small;">
                                            <a target="__blank" href="{{'https://sepolia.etherscan.io/tx/'+lastTxHash}}">
                                                Ver transa&ccedil;&atilde;o
                                            </a>
                                        </p>

                                        <button class="btn btn-sm btn-primary"
                                            ng-click="continueAfterDeposit()"
                                            type="button">
                                            Depositar
                                        </button>
                                    </div>
                                </div>

                                <div class="input-group" style="margin-top: 10px;"
                                    ng-if="!hasDeposited">
                                  <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Amount</span>
                                  <input type="number" class="form-control" aria-label="0" 
                                    ng-disabled="xloading"
                                    placeholder="000000000000 Wei" 
                                    required 
                                    ng-model="depositReq.amount" />
                                  <span class="input-group-addon"
                                    style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;background: gray;font-size: small;">Wei</span>
                                </div>

                                <p style="font-size:small"
                                    ng-if="!hasDeposited">
                                    <span style="color:#333">Min amount:</span> 
                                    <span style="font-weight: bold;">{{MIN_INVESTMENT_AMOUNT}} Wei</span>
                                    <span> | </span>
                                    <a href="javascript:void(0)" style="padding-left:8px"
                                       ng-click="depositReq.show_options = !depositReq.show_options">
                                        <u>More options</u>
                                    </a>
                                </p>

                                <div ng-if="depositReq.show_options && !hasDeposited">

                                    <div class="input-group" style="margin-top: 10px;">
                                      <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Max Gas</span>
                                      <input type="number" class="form-control" aria-label="0" 
                                        ng-disabled="xloading"
                                        placeholder="000000000000" 
                                        required 
                                        ng-model="depositReq.gas" />
                                    </div>

                                    <div class="input-group" style="margin-top: 10px;">
                                      <span class="input-group-addon bg-success" style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;font-size: small;">Gas Price</span>
                                      <input type="text" class="form-control" aria-label="0" 
                                        ng-disabled="xloading"
                                        placeholder="000000000000 Wei" 
                                        required 
                                        ng-model="depositReq.gasPrice" />
                                      <span class="input-group-addon"
                                        style="color: #fff;padding-top: 7px;padding-right: 10px;padding-left: 10px;background: gray;font-size: small;">Wei</span>
                                    </div>

                                </div>

                                <div class="join-area text-center" style="margin-top:15px" 
                                    ng-if="!hasDeposited">
                                    <button class="btn btn-block btn-primary"
                                        type="submit" 
                                        ng-disabled="xloading">
                                        Depositar
                                    </button>
                                    <p style="font-size:x-small;" class="text-secondary">By making deposits you are to our <a href=""><u>terms of service</u></a></p>                          
                                </div>

                            </form>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div ng-if="error" class="alert alert-danger" >
            <h3>Nao foi possivel concluir</h3>
            <p class="text-secondary"
                ng-repeat="e in msg"
                style="font-size:small">
                {{e}}
            </p>
        </div>

        <div ng-if="loading">
            <h3><span class="fa fa-refresh fa-spin"></span>Hold on...</h3>
        </div>
    </div>
</div>

<script type="text/javascript">

	appModule.controller("WalletCtrl", function($q, $sce, $timeout, $http, $scope, WalletService){
        $scope.no_metamask = false;
        $scope.current_wallet = false;
        // https://ethereum-sepolia-rpc.publicnode.com
        // https://rpc.sepolia.org
        // const web3 = new Web3("https://rpc2.sepolia.org");
        const web3 = new Web3("https://ethereum-sepolia-rpc.publicnode.com");
        window.web3 = web3;
        const MIN_INVESTMENT_AMOUNT=1289;

        $scope.joinReq={
            gas: 1000000,
            gasPrice: 3000000000
        };

        $scope.depositReq={
            gas: 1000000,
            gasPrice: '3000000000'
        };

        $scope.MIN_INVESTMENT_AMOUNT=MIN_INVESTMENT_AMOUNT;

        $scope.continueAfterDeposit = function () {
            $scope.hasDeposited=false;
            $scope.lastTxHash='';
        }

        $scope.Deposit = function (form) {
            if (form.$invalid) {
                return;
            }

            $scope.xerror=false;
            const depositReq=$scope.depositReq;
            const amount = depositReq.amount;

            if (!amount || amount<0) {
                $scope.xerror = ["Amount cannot be negative or zero!"];
                return;
            }

            if (depositReq.amount < MIN_INVESTMENT_AMOUNT) {
                $scope.xerror = ["Min investment amount is "+MIN_INVESTMENT_AMOUNT];
                return;                
            }

            $scope.xloading=true;
            $scope.hasDeposited=false;

            const FUND = $scope.ContractFund;
            const Address=$scope.current_wallet.Address;

            FUND.methods.deposit().send({
                value: amount,
                gas: depositReq.gas,
                gasPrice:depositReq.gasPrice,
                from: Address
            })
            .then(function (Resp){
                // console.info("deposit: Resp: ", Resp);
                $timeout(function () {
                    $scope.lastTxHash = Resp.transactionHash;
                    $scope.xloading=false;
                    // $scope.show_options=false;
                    $scope.hasDeposited=true;
                    $scope.loadContractDetails(FUND);
                }, 20);

            }, function (error){
             console.error("deposit() FAILED: ", error)   
                $timeout(function () {
                    $scope.xloading=false;
                    $scope.xerror = [error.message];
                }, 20);
            })
        }

        $scope.JoinFund = function (form) {
            if (form.$invalid) {
                return;
            }

            $scope.jerror=false;
            const joinForm=$scope.joinReq;

            if (!joinForm.amount || joinForm.amount<0) {
                $scope.jerror = ["Amount cannot be negative or zero!"];
                return;
            }

            if (joinForm.amount < MIN_INVESTMENT_AMOUNT) {
                $scope.jerror = ["Min investment amount is "+MIN_INVESTMENT_AMOUNT];
                return;                
            }

            $scope.jloading=true;

            const FUND = $scope.ContractFund;
            const Address=$scope.current_wallet.Address;

            // WalletService.AutorizeTx({
            //     value: joinForm.amount,
            //     desc: "Contract Execution",
            //     from: Address
            // }).then(function (auth) {
            //     // body...
            //     // auth.gas
            //     // auth.gasPrice
            //     // auth.Address
            //     // auth
            //     FUND.methods.join().send(auth)
            //     // FUND.methods.join().send({
            //     //     value: joinForm.amount,
            //     //     gas:1000000,
            //     //     gasPrice:'1000000000',
            //     //     from: Address
            //     // })
            // })

            FUND.methods.join().send({
                value: joinForm.amount,
                gas: joinForm.gas,
                gasPrice:joinForm.gasPrice,
                from: Address
            })
            .then(function (Resp){
                console.info("Resp: ", Resp);
                $timeout(function () {
                    $scope.jloading=false;
                    $scope.isJoined=true;

                    $timeout(function () {
                        $scope.loadContractDetails(FUND);
                    }, 2228);

                }, 20);
            }, function (error){
             console.error("join() FAILED: ", error)   
                $timeout(function () {
                    $scope.jloading=false;
                    $scope.jerror = [error.message];
                }, 20);
            })
        }

        $scope.loadWallet = function () {
            // window.ethereum.request({method: 'eth_requestAccounts'})
            // .then(function (done_) {
            //     web3.eth.getAccounts()
            //     .then(function (Accounts) {
            //         console.info("Accounts: ", Accounts);
            //     }, function (error){
            //     });
            // }, function (error){
            // })

            const wallet_g = localStorage.getItem("__WALLET");
            if (wallet_g!=null) {
                const obj=JSON.parse(wallet_g);
                const wallet_address = obj.Address;
                // console.info("wallet: ", obj);
                $scope.current_wallet = obj;


                web3.eth.getBalance(wallet_address)
                .then(function (Val) {
                    $timeout(function () {
                        $scope.current_wallet.balance=web3.utils.fromWei(Val,'ether');
                    }, 60);
                });
            }
        }

        $scope.createWallet = function () {
            // https://eth-sepolia.g.alchemy.com/v2/demo
            const W = web3.eth.accounts.create();

            const wall = {
                createdAt: moment().format("YYYY-MM-DDTHH:mm"),
                Address: W.address,
                PrivateKey: W.privateKey,
            }

            console.info("wall: ", wall);

            localStorage.setItem("__WALLET", JSON.stringify(wall));
            $scope.current_wallet = wall;
            web3.eth.getBalance(wall.Address)
            .then(function (Val) {
                $timeout(function () {
                    $scope.current_wallet.balance=web3.utils.fromWei(Val,'ether');
                }, 60);
            });
        }

        $scope.removeWallet = function() {
            if (!confirm("Tem a certeza que deseja eliminar a wallet?")) {
                return;
            }

            localStorage.removeItem("__WALLET");
            $scope.current_wallet = false;
        }

        $scope.DeployContract = function () {
            if (!confirm("Deploy contract?")) {
                return;
            }

            const privateKey = "";

            const wallet = web3.eth.wallet.add(privateKey);

            const bytecode = $("#ATTR_ID").attr("data-bytecode");
            const myContract = new web3.eth.Contract(__ABIX);

            const deployer = myContract.deploy({
                data: "0x"+bytecode,
                arguments: ["NewFundManaged"]
            });

            $scope.loading=true;
            $scope.error=false;
            $scope.msg=false;

            deployer.send({ from: wallet[0].address })
            .then(function (Res) {
                $timeout(function () {
                    $scope.loading=false;
                    $scope.is_deployed=true;
                    console.info("Res: ", Res);
                }, 50);

            }, function (error) {
                console.error("ERROR: ", error);
                $timeout(function () {
                    $scope.loading=false;
                    $scope.error=true;
                    $scope.msg=[error.message];
                }, 50);
            });
        }

        $scope.loadContractDetails = function (CT) {
            var q = [
                CT.methods.getBalance().call(),
                CT.methods.myBalance().call()
            ];

            $scope.loading=true;

            Promise.allSettled(q)
            .then(function (Ary) {
                $timeout(function () {
                    if (Ary[0].status=='fulfilled') {
                        var etherAmount = web3.utils.fromWei(Ary[0].value, "ether")
                        $scope.contract_amount = etherAmount;                        
                    }

                    if (Ary[1].status=='fulfilled') {
                        var etherAmount = web3.utils.fromWei(Ary[1].value, "ether")
                        $scope.my_balance = etherAmount;
                    } else {
                        $scope.my_balance = 0;
                    }

                    $scope.loading=false;
                }, 40);
            })
        }

        $scope.LoadContract = function () {
            // const CT_ADDR='0x5e78F2Aa5616205948F495a2C4b9fF92D842b76e';
            // const CT_ADDR='0xFf999089749b684250C825A713258A649AD00F16';
            // const CT_ADDR='0x40BbA404d51e951FeeC83078bec24AE367546978';
            const CT_ADDR='0xE92e05382529AEeE47a686846d8F86267E5A825d';

            $scope.CT_ADDR = CT_ADDR;
            const wallet = web3.eth.wallet.add($scope.current_wallet.PrivateKey);
            const investmentFUND = new web3.eth.Contract(__ABIX, CT_ADDR, {from: $scope.current_wallet.Address});

            $scope.ContractFund = investmentFUND;
            $scope.loadContractDetails(investmentFUND);
            // console.info("wallet: ", wallet[0]);
            // investmentFUND.methods.deposit().send({
            //     value:1823,
            //     gas:1000000,
            //     gasPrice:'10000000000',
            //     from:'0xa285A56Bb18cb9b41347EFD9720066322c3468Fa'
            // })
            // .then(function (balance){
            //     console.info("balance: ", balance);
            // }, function (error){
            //  console.error("FAILED", error)   
            // })

            // investmentFUND.methods.join().send({
            //     value:1823,
            //     gas:1000000,
            //     gasPrice:'1000000000',
            //     from: wallet.address[0]
            // })
            // .then(function (Resp){
            //     console.info("Resp: ", Resp);
            // }, function (error){
            //  console.error("FAILED", error)   
            // })
        }
	});

    appModule.factory("WalletService", function ($http, $q) {
        function AutorizeTx(reqConf) {
            // body...
        }

        return {
            AutorizeTx: AutorizeTx,
            ABI: __ABIX
        }
    });
</script>

