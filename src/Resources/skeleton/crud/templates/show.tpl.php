{% extends '<?= $templates_path ?>/base.html.twig' %}
{% import "themes/hyper/saas/macros/dropdown.html.twig" as dropdown %}

{% block title %}
    {{ 'app.titles.show'|trans({'name': '<?= $route_name ?>.designation.singular'|trans}) }}
{% endblock %}
{% block headline %}
    {{ 'app.headlines.show'|trans({'name': '<?= $route_name ?>.designation.singular'|trans}) }}
{% endblock %}

{% block entity_body %}

    {{ dropdown.dropdownActions(
        {
            0: {
            'path': path('<?= $route_name ?>_edit', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}),
            'name': 'app.edit'|trans
        },
            1: {
            'delete': true,
            'path': path('<?= $route_name ?>_delete', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}),
            'csrf_token': csrf_token('delete' ~ <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>)
        }
        }
    ) }}

    <table class="table">
        <tbody>
<?php foreach ($entity_fields as $field): ?>
            <tr>
                <th>{{ '<?= $route_name ?>.parameter.<?= $field['columnName'] ?>'|trans }}</th>
                <td>{{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}</td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <a href="{{ path('<?= $route_name ?>_index') }}">{{ 'app.back_to_list'|trans }}</a>
{% endblock %}
