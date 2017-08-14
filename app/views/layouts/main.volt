<nav><h1>Vending Machine</h1></nav>
<div class="container">
    <div class="row">
        <div id="costumer" class="col-sm-4 panel panel-default">
            <div class="panel-heading"> Кашелёк {{ customerBalance }} руб</div>
            <div class="panel-body">
                <p>Нажмите монетку, чтобы вставить ёё</p>
                {%  for coin in coins  %}
                <div class="thumbnail col-sm-2">
                     <a href="{{ baseUrl }}/main/coinInserted/{{ coin.value }}">
                         <img src="{{ coin.imageUrl }}"  class="img-rounded" width="50" height="50" >
                        <div class="caption">
                            <p>{{ coin.quantity }}</p>
                        </div>
                     </a>
                </div>
                {% endfor %}

            </div>
        </div>
        <div id="balance" class="col-sm-4 panel panel-default">
            <div class="panel-heading">Внесенная сумма {{ vmBalance }} руб</div>
            <div class="panel-body">
                <a class="btn btn-warning" href="{{ baseUrl }}/main/getChange/"> Сдача</a>
                <h3>{{ message }}</h3>
            </div>
        </div>
        <div id="machine" class="col-sm-4 panel panel-default">
            <div class="panel-heading">Автомать</div>
            <div class="panel-body">
                {%  for product in products %}
                    <a href="{{ baseUrl }}/main/productSelected/{{ product.id }}/">
                        <b>{{ product.name }}</b>
                        <i>{{ product.price }} руб</i>
                       ( осталось  {{ product.quantity }} шт.)<br>
                    </a>
                {% endfor %}

                <h1>Автомат {{ vmSum }}</h1>
                {% for coin in vendingCoins %}
                    {{ coin.value }} руб * {{ coin.quantity }} ;
                {% endfor %}
            </div>
        </div>
    </div>

    <a href="{{ baseUrl }}/main/reset" class="btn btn-danger">Сброс</a>

</div>
