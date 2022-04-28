{% extends 'base.index.html.twig' %}

{% block title %}
    {{ 'app.titles.index'|trans({'name': '<?= $route_name ?>.designation.plural'|trans}) }}
{% endblock %}
{% block headline %}
    {{ 'app.headlines.index'|trans({'name': '<?= $route_name ?>.designation.plural'|trans}) }}
{% endblock %}

{% block index_body %}

    <table class="table">
        <thead>
            <tr>
<?php foreach ($entity_fields as $field): ?>
                <th>{{ '<?=$route_name ?>.parameter.<?=$field['columnName'] ?>'|trans }}</th>
<?php endforeach; ?>
                <th>{{ 'app.actions'|trans }}</th>
            </tr>
        </thead>
        <tbody>
        {% for <?= $entity_twig_var_singular ?> in <?= $entity_twig_var_plural ?> %}
            <tr>
<?php foreach ($entity_fields as $field): ?>
                <td>{{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}</td>
<?php endforeach; ?>
                <td>
                    <a href="{{ path('<?= $route_name ?>_show', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}">{{ 'app.show'|trans }}</a>
                    <a href="{{ path('<?= $route_name ?>_edit', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}">{{ 'app.edit'|trans }}</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan="<?= (count($entity_fields) + 1) ?>">{{ 'app.no_records_found'|trans }}</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <a href="{{ path('<?= $route_name ?>_new') }}">{{ 'app.create_new'|trans }}</a>
{% endblock %}
