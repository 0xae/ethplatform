<div class="row" 
    style="background: #fff;padding: 10px;" 
	ng-controller="MainCtrl">

    <div class="col-12">
        <div class="alert alert-warning" 
            ng-if="no_metamask===true">
            Instale o <a href="https://metamask.io/">Metamask</a> para usar esta aplicacao.
        </div>
    </div>

    <div class="col-12"
        style="text-align: center;border: 1px solid #ccc;padding-top: 100px;padding-bottom: 100px;">
        <div ng-if="!wallet_connected && !loading">
            <img src="METAMASK.png" width="50px" />
            <h3>Connecte o seu wallet abaixo!</h3>
            <p class="text-secondary"
                style="font-size:small">A wallet usa o metamask para enviar as transacoes.</p>
            <button class="btn btn-primary"
                ng-click="connectWallet()"
                ng-disabled="loading">
                Conectar Wallet
            </button>
        </div>

        <div ng-if="loading">
            <img src="METAMASK.png" width="50px" />
            <h3>Aguardando...</h3>
            <p class="text-secondary"
                style="font-size:small">
                Navegue ao topo do navegador, localize o icone das extensoes
                e abra o metamask.</p>
            <img src="CONNECT.png" width="200px" />
        </div>

<!--         <div class="alert">
            <p>{{message}}</p>
        </div>
 -->
        <div ng-if="wallet_connected">
            <p>Address: {{wallet_address}}</p>
            <p>Balance: {{wallet_balance}}</p>
        </div>
    </div>
</div>

<script type="text/javascript">
	appModule.controller("MainCtrl", function($q, $sce, $timeout, $http, $scope){
        $scope.no_metamask = false;

        $scope.connectWallet = function() {
            if (!window.ethereum) {
                alert("Instalar Metamask");
                $scope.no_metamask=true;
                return;
            }

            const web3 = new Web3(window.ethereum);
            window.web3 = web3;

            // const wallet_g = localStorage.getItem("__WALLET");
            // if (wallet_g!=null) {
            //     const obj=JSON.parse(wallet_g);
            //     const wallet_address = obj.Account;

            //     $scope.wallet_address = wallet_address;
            //     $scope.message="CONNECTED";
            //     $scope.wallet_connected = true;

            //     web3.eth.getBalance(wallet_address)
            //     .then(function (Val) {
            //         $timeout(function () {
            //             $scope.wallet_balance=Val+"";
            //         }, 60);
            //     });

            //     return;
            // }

            $scope.message = "Abra O Metamask e aprove a conexao!";
            $scope.loading=true;

            window.ethereum.request({method: 'eth_requestAccounts'})
            .then(function (done_) {
                web3.eth.getAccounts()
                .then(function (Accounts) {
                    console.info("Accounts: ", Accounts);
                    $timeout(function () {
                        $scope.message="CONNECTED";
                        $scope.wallet_connected = true;
                        $scope.loading = false;

                        const wallet_address=Accounts[0];
                        $scope.wallet_address = wallet_address;
                        // localStorage.setItem("__WALLET", JSON.stringify({Account: wallet_address}))

                        web3.eth.getBalance(wallet_address)
                        .then(function (Val) {
                            $timeout(function () {
                                $scope.wallet_balance=Val+"";
                            }, 60);
                        });
                    }, 60);

                }, function (error){
                    $timeout(function () {
                        console.error("ERR: ", error);
                        $scope.message = "FAILED TO GET ACCOUNTS";
                        $scope.loading=false;
                    }, 60);
                });

            }, function (error){
                $timeout(function () {
                    console.error("ERR: ", error);
                    $scope.message = "FAILED TO OBTAIN PERMISSION";
                    $scope.loading=false;
                }, 60);
            })
        }
	});
</script>

