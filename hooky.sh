#!/usr/bin/env sh
if [ -z "$hooky_skip_init" ]; then
  debug () {
    if [ "$HOOKY_DEBUG" = "1" ]; then
      echo "hooky (debug) - $1"
    fi
  }

  readonly hook_name="$(basename -- "$0")"
  debug "starting $hook_name..."

  if [ "$HOOKY" = "0" ]; then
    debug "HOOKY env variable is set to 0, skipping hook"
    exit 0
  fi

  if [ -f ~/.hookyrc ]; then
    debug "sourcing ~/.hookyrc"
    . ~/.hookyrc
  fi

  readonly hooky_skip_init=1
  export hooky_skip_init
  sh -e "$0" "$@"
  exitCode="$?"

  if [ $exitCode != 0 ]; then
    echo "hooky - $hook_name hook exited with code $exitCode (error)"
  fi

  if [ $exitCode = 127 ]; then
    echo "hooky - command not found in PATH=$PATH"
  fi

  exit $exitCode
fi
