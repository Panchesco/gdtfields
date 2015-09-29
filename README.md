# gdtfields

ExpressionEngine 2 Plugin to return data about channel fields parsed for output to templates.

###Tag Pairs

```
{exp:gdtfields:field_list_items field_name="{channel_field_name}"}
  {field_list_item}
{exp:gdtfields:field_list_items}
```

```
{exp:gdtfields:channel_field field_name="{channel_field_name}"}
  {field_id}
  {site_id}
  {field_name}
  {field_label}
  {field_instructions}
  {field_type}
  {field_list_items}
  {field_max}
  {field_required}
  {field_text_direction}
  {field_search}
  {field_hidden}
  {field_fmt}
  {field_order}
  {field_content_type}
{/exp:gdtfields:channel_field}
```
###Required Parameters
```
field_name
```

