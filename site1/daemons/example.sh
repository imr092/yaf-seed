#!/bin/sh

## daemon

_scriptName="example"
_dataPath=$(cd "$(dirname "$0")"; pwd)/
_dumpLogPath="${_dataPath}log/dump_${_scriptName}_`date +%Y%m%d`"
_daemonLogPath="${_dataPath}log/daemon_${_scriptName}_`date +%Y%m%d`"
_execStr="/usr/local/php/bin/php ${_dataPath}${_scriptName}.php"

_workerCount=$(ps aux | grep "${_execStr}" | grep -v "grep" | wc -l)
echo "[`date +%Y-%m-%d` `date +%T`]  worker count : ${_workerCount}" >> "${_daemonLogPath}"
if [ "$_workerCount" -lt 1 ]; then
	nohup ${_execStr} >> ${_dumpLogPath} 2>&1 &
	echo "process started!"
    echo "[`date +%Y-%m-%d` `date +%T`] start new worker !" >> "${_daemonLogPath}"
fi
exit