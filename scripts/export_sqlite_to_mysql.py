from __future__ import annotations

import argparse
import sqlite3
from pathlib import Path


TABLES_IN_ORDER = [
    "users",
    "categories",
    "products",
    "product_color_variants",
    "product_color_variant_images",
    "orders",
    "order_items",
    "quote_requests",
]


def mysql_literal(value: object) -> str:
    if value is None:
        return "NULL"

    if isinstance(value, bool):
        return "1" if value else "0"

    if isinstance(value, (int, float)):
        return str(value)

    if isinstance(value, bytes):
        return "0x" + value.hex()

    text = str(value)
    text = text.replace("\\", "\\\\")
    text = text.replace("'", "''")
    text = text.replace("\r", "\\r").replace("\n", "\\n")

    return f"'{text}'"


def fetch_columns(cursor: sqlite3.Cursor, table: str) -> list[str]:
    cursor.execute(f'PRAGMA table_info("{table}")')
    return [row[1] for row in cursor.fetchall()]


def dump_table(cursor: sqlite3.Cursor, table: str) -> str:
    columns = fetch_columns(cursor, table)
    column_list = ", ".join(f"`{column}`" for column in columns)

    cursor.execute(f'SELECT * FROM "{table}"')
    rows = cursor.fetchall()

    statements = [f"-- Table: {table}", f"DELETE FROM `{table}`;"]

    for row in rows:
        values = ", ".join(mysql_literal(value) for value in row)
        statements.append(f"INSERT INTO `{table}` ({column_list}) VALUES ({values});")

    statements.append("")

    return "\n".join(statements)


def main() -> None:
    parser = argparse.ArgumentParser(
        description="Exporta datos de SQLite a un SQL de datos compatible con MySQL.",
    )
    parser.add_argument(
        "--input",
        default="database/database.sqlite",
        help="Ruta al archivo SQLite de origen.",
    )
    parser.add_argument(
        "--output",
        default="database/mysql_data_from_sqlite.sql",
        help="Ruta del archivo SQL de salida.",
    )
    args = parser.parse_args()

    input_path = Path(args.input)
    output_path = Path(args.output)

    connection = sqlite3.connect(input_path)
    cursor = connection.cursor()

    sections = [
        "-- Export generado desde SQLite para importar datos en MySQL.",
        "-- Recomendado: ejecutar primero `php artisan migrate --force` sobre MySQL.",
        "SET NAMES utf8mb4;",
        "SET FOREIGN_KEY_CHECKS=0;",
        "",
    ]

    for table in TABLES_IN_ORDER:
        sections.append(dump_table(cursor, table))

    sections.append("SET FOREIGN_KEY_CHECKS=1;")
    sections.append("")

    output_path.write_text("\n".join(sections), encoding="utf-8")

    connection.close()


if __name__ == "__main__":
    main()
