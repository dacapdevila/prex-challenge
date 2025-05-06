#!/usr/bin/env bash
set -e

HOOKS_DIR=".git/hooks"
SOURCE_DIR="githooks"

mkdir -p "$HOOKS_DIR"

for hook in pre-commit pre-push; do
  echo "Installing $hook hook"
  cp "$SOURCE_DIR/$hook" "$HOOKS_DIR/$hook"
  chmod +x "$HOOKS_DIR/$hook"
done

echo "✅ Git hooks installed!"
