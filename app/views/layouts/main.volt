<nav><h1>Vending Machine</h1></nav>
<div class="container">
    <div class="row">
        <div id="costumer" class="col-sm-4 panel panel-default">
            <div class="panel-heading"> Покупатель {{ customerBalance }} руб</div>
            <div class="panel-body">
                {#{{ coins }}#}
                {%  for coin in coins  %}
                <div class="thumbnail">
                     <a href="http://localhost//virtual-vm/main/coinInserted/{{ coin.value }}">
                        <img src="{{ coin.imageUrl }}"  >
                        <div class="caption">
                            <p>{{ coin.quantity }}</p>
                        </div>
                     </a>
                </div>
                {% endfor %}

            </div>
        </div>
        <div id="balance" class="col-sm-4 panel panel-default">
            <div class="panel-heading">Внесенная сумма {{ vmCache }} руб</div>
            <div class="panel-body">
                <h1>Баланс </h1>
            </div>
        </div>
        <div id="machine" class="col-sm-4 panel panel-default">
            <div class="panel-heading">Автомать</div>
            <div class="panel-body">
                <h1>Автомат {{ vmBalance }}</h1>
            </div>
        </div>
    </div>

</div>
