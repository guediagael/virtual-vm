<nav><h1>Vending Machine</h1></nav>
<div class="container">
    <div class="row">
        <div id="costumer" class="col-sm-4 panel panel-default">
            <div class="panel-heading"> Покупатель {{ customerBalance }} руб</div>
            <div class="panel-body">
                {%  for coin in coins  %}
                <div class="thumbnail">
                     <a href="{{ baseUrl }}/main/coinInserted/{{ coin.value }}">
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
                <a class="btn btn-warning" href="{{ baseUrl }}/main/getBalance/"> Сдача</a>
                <h3>{{ message }}</h3>
            </div>
        </div>
        <div id="machine" class="col-sm-4 panel panel-default">
            <div class="panel-heading">Автомать</div>
            <div class="panel-body">
                <ul>
                    {%  for product in products %}
                        <li>
                            <a href="{{ baseUrl }}/main/productSelected/{{ product.id }}/">
                                <h1>{{ product.name }}</h1>
                                <h2>{{ product.price }} руб</h2>
                                <h3> {{ product.quantity }}</h3>
                            </a>
                        </li>
                    {% endfor %}
                </ul>

                <h1>Автомат {{ vmBalance }}</h1>
            </div>
        </div>
    </div>

</div>
