# Instruções

- Nunca utilize travessão.
- Nunca utilize emojis.

# Convenções do projeto

- Todo o sistema usa soft delete: toda tabela de entidade leva `$table->softDeletes()` na migration e o model usa a trait `SoftDeletes`.
