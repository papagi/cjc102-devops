#!/bin/sh
set -e
# CI 階段單純啟動即可，不需要複雜的搬移邏輯
exec "$@"